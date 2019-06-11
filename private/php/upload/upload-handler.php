<?php
require_once($phpPaths['PHP'] . '/custom-exceptions.php');
require_once($phpPaths['PHP'] . '/user-data.php');
require_once($phpPaths['PHP'] . '/account-data.php');
require_once($phpPaths['PHP'] . '/db-connect.php');
require_once($phpPaths['PHP'] . '/ip-retriever.php');
require_once($phpPaths['PHP'] . '/upload/storage.php');

class UploadHandler
{
	//$files - assoc array field from $_FILES superglobal
	//$destDir - directory where files will be saved
	public function __construct(array $files, string $destDir)
	{
		$this->files = $files;
		$this->destDir = $destDir;
		$this->handleErrors();
		$this->handleConstraints();
	}

	//returns file name under which file can be saved on server side
	//returned name will be unique withing path directory and won't contain any illegal characters
	public function getFileNameToSave(string $clientFileName)
	{
		$name = $this->replaceIllegalChars($clientFileName);

		$parts = pathinfo('/' . $clientFileName);
		//get file extension if it has one
		$ext = ( empty($parts['extension']) ) ? '' : '.' . $parts['extension'];
		//get filename without extenion(if name contains only extension
		//empty string will be returned)
		$withoutExt = $parts['filename'];

		//if file with that name already exists append some number to name 
		//before extension part
		for ($i = 1 ; file_exists($this->destDir . '/' . $name) ; $i++)
			$name = $withoutExt . $i . $ext;
				
		return $name;
	}

	//saves files on server side
	public function upload()
	{
		$filesProceed = [];
		for ($i = 0 ; $i < count($this->files['name']) ; $i++)
		{
			//if file didn't match constraints or error occured go to next iteration
			if ( $this->uploadSummary[$i]['errorId'] )
				continue;

			//get file name under which file will be saved
			$saveName = $this->getFileNameToSave($this->files['name'][$i]);

			//save file
			if ( !move_uploaded_file($this->files['tmp_name'][$i], 
				$this->destDir . '/' . $saveName) )
			{
				//error while saving
				throw new MoveUploadedFileException($this->files['name'][$i]);
			}
			//give 644 rights
			chmod($this->destDir . '/' . $saveName, 0644);

			$this->uploadSummary[$i]['serverName'] = $saveName;
		}

		//save data about uplaoded files in database
		$this->saveUploadsInDB();
	}

	//retuns array of
	/*
	[
		clientName - name of a file on client machine
		serverName - name of the same file on server side
		errorId - id of an error(0 if no errors)
		errorMsg - errorr message content if error occured
	]
	*/
	public function getSummary()
	{
		return $this->uploadSummary;
	}

	//PRIVATE SECTION 

	private $files;
	private $destDir;
	private $uploadSummary;

	//errors IDs
	const ERR_SUCCESS = 0;
	const ERR_UPLOAD_ERROR = 1;
	const ERR_CONSTRAINT = 2;

	//returns filename that contains underscores in places where illegal characters occured
	private function replaceIllegalChars($filename)
	{
		return preg_replace('/[^a-zA-Z0-9\._]/', '_', $filename);
	}

	//check if files that are to be uploaded match user's upload constraints
	//if file don't match some constraint don't save it and set appropriate
	//error message in uploadSummary array
	private function handleConstraints()
	{
		$account = UserData::constructCurrentClient()->get()['accountType'];
		$uploadConstraints = ( new AccountData($account) )
			->getUploadConstraints();

		if ( !$this->matchMaxStorageSizeConstraint() )
		{
			$this->setConstraintErrorAll(
				'Wykorzystano limit rozmiaru jakie mogą zajmować Twoje pliki!');
		}
		else if ( !$this->matchMaxNumUploadsConstraints($uploadConstraints) )
		{
			$this->setConstraintErrorAll(
				'Przekroczono maksymalną ilość przesyłanych naraz plików!');
		}
		else
			$this->handleMaxFilesSizeConstraint($uploadConstraints);
	}

	//sets to all files in uploadSummary array error id to constraint error
	//and sets error message passed as parameter
	private function setConstraintErrorAll(string $errMsg)
	{
		for ($i = 0 ; $i < count($this->uploadSummary) ; $i++)
			$this->setConstraintError($errMsg, $i);
	}

	private function setConstraintError(string $errMsg, int $index)
	{
		unlink($this->files['tmp_name'][$index]);
		$this->uploadSummary[$index]['errorId'] = self::ERR_CONSTRAINT;
		$this->uploadSummary[$index]['errorMsg'] = $errMsg;
	}

	//returns true if max storage size won't be exceeded
	private function matchMaxStorageSizeConstraint()
	{
		//calculate sum of user's used size of storage and otal size of uplaoded
		//files in this script
		$storage = UserStorage::constructCurrentClient();
		$sumSize = array_sum($this->files['size']) + $storage->getUsedSize();

		return ( $sumSize <= $storage->getMaxSize() );
	}

	//returns true if file size don't exceed the limit
	private function matchMaxFileSizeConstraint(array $uploadConstraints, int $size)
	{
		return $size <= $uploadConstraints['maxFileSize'];
	}

	//returns true if number of uploads don't exceed the limit
	private function matchMaxNumUploadsConstraints(array $uploadConstraints)
	{
		return ( count($this->files['name']) <= $uploadConstraints['maxNum'] );
	}

	//checks if file size max limit wasn't exceeded
	private function handleMaxFilesSizeConstraint(array $uploadConstraints)
	{
		for ($i = 0 ; $i < count($this->files['size']) ; $i++)
		{
			$size = $this->files['size'][$i];
			if ( !$this->matchMaxFileSizeConstraint($uploadConstraints, (int)$size) )
			{
				$this->setConstraintError('Przekroczono maksymalny rozmiar pliku '
				 . round( $uploadConstraints['maxFileSize'] / GB, 2 )
				 . ' GB!', $i);
			}
		}
	}

	//if 'error' field in $files array differs from 0 set error id within
	//uploadSummary array
	private function handleErrors()
	{
		for ($i = 0 ; $i < count($this->files['error']) ; $i++)
		{
			//get error code of currently iterated file
			$errCode = $this->files['error'][$i];
			if ($errCode)
			{
				//error occured while uploading, set error id and 
				//translate error to string message
				$this->uploadSummary[] = [

					'errorId' => self::ERR_UPLOAD_ERROR,
					'errorMsg' => $this->getStrError($errCode),
					'clientName' => $this->files['name'][$i]
				];

				//remove that file from temporary directory
				unlink($this->files['tmp_name'][$i]);
			}
			else
			{
				//no errors, set error flag to success
				$this->uploadSummary[] = [
					'errorId' => self::ERR_SUCCESS,
					'errorMsg' => null,
					'clientName' => $this->files['name'][$i]
				];
			}
		}
	}

	//returns translated error code to string message from 'error'
	//field in files array
	private function getStrError(int $errCode)
	{
		switch ($errCode)
		{
		case 1:
			return 'Zbyt duży plik!';
		case 3:
			return 'Plik przesłany tylko w części!';
		case 4:
		case 6:
			return 'Brak folderu plików tymczasowych!';
		case 7:
			return 'Nie udało zapisać się pliku na dysku!';
		default:
			return 'Wystąpił nieznany błąd!';
		}
	}

	//saves all paths to files that have corresponding entry 'errorId'
	//in uploadSummary set to 0
	private function saveUploadsInDB()
	{
		foreach ($this->uploadSummary as $upload)
		{
			if ($upload['errorId'] === 0)
			{
				$this->saveUploadInDB($this->destDir . '/' . $upload['serverName'],
					$upload['clientName']);
			}
		}
	}

	//appends row to uploaded_files table with path to uploaded file and its name
	//on client side
	private function saveUploadInDB(string $serverPath, string $clientFilename)
	{
		$db = connectToDB();
		$stmt = $db->prepare("INSERT INTO uploaded_files (owner_id, 
		owner_ip, client_filename, path)
		VALUES(?, ?, ?, ?)");
		//ownerId is an id of session client if that client is logged in
		//or null otherwise
		$ownerId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
		$stmt->execute([ $ownerId, getClientIp(), $clientFilename, $serverPath ]);
	}
}