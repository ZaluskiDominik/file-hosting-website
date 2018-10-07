<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/config.php');
require_once($phpPaths['PHP'] . 'db-manager.php');

class UploadValidation
{
	//array with validation results, it will be used to create json response to client
	private $validResult;

	public function __construct()
	{
		$this->initValidateResultArray();
	}

	//validate files, create validResult array
	public function validate()
	{
		//global errors
		$this->checkIfNotEmpty();
		$this->validateMaxStorageSizeLimit();

		//per file errors
		for ($i = 0 ; $i < count($_FILES['files']['size']) ; $i++)
		{
			$this->checkFilesArrayError($i);
			$this->validateFileSize($i);
		}

		//loop through all file's erros messages
		foreach ($this->validResult['errors']['perFile'] as $err)
		{
			//if an error occured end script and output json info about validation result
			if ($err != "")
				$this->outputJsonValidationResult();
		}
	}

	//returns validResult array
	public function getValidationResult()
	{
		return $this->validResult;
	}

	//returns json formatted validResult array
	public function outputJsonValidationResult()
	{
		die( json_encode($this->validResult) );
	}

	//creates array that will contain validation errors
	private function initValidateResultArray()
	{
		$this->validResult = [
			'success' => false,
			'errors' => [
				'global' => '',
				//perFile --> array of error string for each file, empty string --> no errors
				'perFile' => []
			],
			'files' => []
		];

		//fill perFile array with empty strings --> no error
		//fill files array with name of each file and empty url(download url will be added after a file is uploaded)
		for ($i = 0 ; $i < count($_FILES['files']['size']) ; $i++)
		{
			$this->validResult['errors']['perFile'][] = "";
			$this->validResult['files'][] = [
				'name' => basename( $_FILES['files']['name'][$i] ),
				'url' => ""
			];
		}
	}

	//check if $_FILES['files'] var isn't empty
	private function checkIfNotEmpty()
	{
		if ( empty($_FILES['files']) )
		{
			$this->validResult['errors']['global'] = "Pliki nie zostały przesłane.<br/>Błąd: Żaden plik nie został wybrany.";
			$this->outputJsonValidationResult();
		}
	}

	//check if sum of all files' sizes doesn't exceed limit
	private function validateMaxStorageSizeLimit()
	{
		//sum sizes of all files
		$uploadSize = 0;
		foreach ($_FILES['files']['size'] as $size)
			$uploadSize += $size;

		//total size of this user's files saved on disc
		$dbUser = new DBManager( ( isset($_SESSION['userId']) ) ? $_SESSION['userId'] : null );
		$storageSize = $dbUser->getUserStorageSize();
		//limit to storage size
		$maxStorageSize = $dbUser->getAccountInfo()['max_storage'];

		//if after this upload total size of user's files on disc exceeds the limit, set error message and exit script
		if ( $storageSize + $uploadSize > $maxStorageSize )
		{
			$this->validResult['errors']['global'] = "Pliki nie zostały przesłane.<br/>Błąd: Przekroczono limit całkowitego rozmiaru przechowywanych przez Ciebie plików na serwerze.";
			$this->outputJsonValidationResult();
		}
	}

	//check if any error occured in $_FILES['files']['error']
	private function checkFilesArrayError($index)
	{
		if ( $_FILES['files']['error'][$index] )
		{
			$this->validResult['errors']['perFile'][$index] = "Plik nie został przesłany.<br/>Błąd: Wystąpił nieznany błąd. Sprawdź czy wybrany plik nie przekracza maksymalnego rozmiaru.";
		}
	}
	
	//validate file's size
	private function validateFileSize($index)
	{
		$dbManager = new DBManager( isset( $_SESSION['userId'] ) ? $_SESSION['userId'] : null );
		$accountInfo = $dbManager->getAccountInfo();
		//if file size is greater that max file size
		if ( $_FILES['files']['size'][$index] > $accountInfo['max_file_size'] )
		{
			$this->validResult['errors']['perFile'][$index] = "Plik nie został przesłany.<br/>Błąd: Plik jest zbyt duży. Maksymalny rozmiar pliku to " . $accountInfo['max_file_size'];
		}
	}
}
?>