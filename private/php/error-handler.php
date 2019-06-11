<?php
require_once($phpPaths['PHP'] . '/restrict-functions.php');

class ErrorHandler
{
	//if $development = true in-depth errors will be displayed
	public function __construct(bool $development = false)
	{
		$this->dev = $development;
	}

	//handler of set_error_handler function
	public function errorHandler(int $errno , string $errstr , string $errfile , int $errline)
	{
		//init error context variables
		$this->initErrVars($errno, $errstr, $errfile, $errline);

		//call main erros handler
		$this->handle();
	}

	//handler of register_shutdown_function
	public function shutdownHandler()
	{
		//get last error
		$err = error_get_last();
		//if any error occured
		if ($err !== null)
		{
			$this->initErrVars($err['type'], $err['message'], $err['file'], $err['line']);
			
			//call main erros handler
			$this->handle();
		}
	}

	//PRIVATE SECTION

	//whether application is in stage of development or production
	private $dev;
	private $line;
	private $file;
	private $msg;
	private $errId;

	//init error context variables	
	private function initErrVars(int $errId , string $msg , string $file , int $line)
	{
		$this->errId = $errId;
		$this->msg = $msg;
		$this->file = $file;
		$this->line = $line;
	}

	//main handler for errors
	private function handle()
	{
		//call appropriate handler depending whether it's a production or development
		if ($this->dev)
			$this->developmentHandler();
		else
			$this->productionHandler();
	}

	//error handler for development stage
	private function developmentHandler()
	{
		//output error
		$errOutput = $this->getFormattedError();
		echo $errOutput;

		//append error log
		$this->appendErrorLog($errOutput);

		http_response_code(500);
		//end script
		exit();
	}

	//error handler for production stage
	private function productionHandler()
	{
		//append error log
		$this->appendErrorLog( $this->getFormattedError() );

		//if error is fatal redirect to 500 internal server error page
		$fatal = [ E_ERROR, E_PARSE, E_CORE_ERROR, E_USER_ERROR, 
		E_RECOVERABLE_ERROR, E_COMPILE_ERROR ];
		if ( in_array($this->errId, $fatal) )
		{
			http_response_code(500);
			redirect('internal-500-error.html');
		}
	}

	private function getFormattedError()
	{
		//formatted error informations
		$errMsg = "<b>Error: [" . $this->file . " " . $this->line . "]</b><br>" . $this->msg;
		//formatted debug backtrace
		$traceStr = "<br>Backtrace:<br>" . $this->getBacktrace();

		return $errMsg . $traceStr . "<br><br>";
	}

	private function appendErrorLog(string $err)
	{
		error_log(preg_replace('/<br>/', PHP_EOL, $err), 0);
	}

	//returns string of chained function calls before error occured
	private function getBacktrace()
	{
		$e = new Exception();
		$trace = explode("\n", $e->getTraceAsString());
		//reverse array to make steps line up chronologically
		$trace = array_reverse($trace);
		array_shift($trace); // remove {main}
		array_pop($trace); // remove call to this method
		$length = count($trace);
		$result = array();

		for ($i = 0; $i < $length; $i++)
		{
		    $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); 
		    //replace '#someNum' with '$i)', set the right ordering
		}

		return "\t" . implode("\n\t", $result);
	}
}

//instance of ErorHandler
$handler = new ErrorHandler(ini_get('display_errors'));

//set handlers for non-fatal errors
set_error_handler([$handler, 'errorHandler']);
//set handler for fatal errors(callback is called whenever script is exited so callback
//implementation needs to check if any fatal error occured)
register_shutdown_function([$handler, 'shutdownHandler']);