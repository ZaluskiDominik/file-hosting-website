<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/config.php');
require_once($phpPaths['PHP'] . 'upload-validation.php');
require_once($phpPaths['PHP'] . 'get-ip-function.php');
require_once($phpPaths['PHP'] . 'db-manager.php');

class Upload
{
	//object that will be returned as response(validation response + download url)
	private $response;

	public function __construct()
	{
		//get validation result
		$validation = new UploadValidation();
		$validation->validate();
		$this->response = $validation->getValidationResult();
		$this->initUploadDir();
	}

	//uploads files
	public function upload()
	{
		//set success flag to true, it will be changed to false if any error occurs while moving a file to the disc
		$this->response['success'] = true;
		for ($i = 0 ; $i < count($_FILES['files']['size']) ; $i++)
		{
			//get path under which file will be stored on disc
			$destFilePath = $this->getDestFilePath($_FILES['files']['name'][$i]);

			//if an errorr occured while moving the file to the disc
			if ( !$this->saveFile($_FILES['files']['tmp_name'][$i], $destFilePath, $i) )
				$this->response['success'] = false;
		}
	}

	public function getResponse()
	{
		return $this->response;
	}

	//creates folder for user's files if it doesn't exist
	private function initUploadDir()
	{
		//if user is logged in
		if ( isset($_SESSION['userId']) )
		{
			//get user's login(signed in user's files are stored in a directory named after his login)
			$userLogin = ( DBManager($_SESSION['userId']) )->getUserData()['login'];
			//set relative path when files will be stored
			$this->uploadDir = UPLOAD_PATH . 'accounts/' . $userData['login'] . '/';
			
		}
		else
		{
			//it's a guest user
			//his files will be saved in folder named after his ip addres
			$this->uploadDir = UPLOAD_PATH . 'guests/' . getClientIp() . '/';
		}

		//create that directory if it doesn't already exist
		if ( !file_exists($this->uploadDir) )
		{
			if ( !mkdir($this->uploadDir) )
			{
				http_response_code(400);
				exit();
			}
		}
	}

	//moves uploaded files from temp location to disc, returns true is operation was successfull
	private function saveFile($tmpPath, $destFilePath, $fileIndex)
	{
		//if the file was moved to disc without errors
		if ( move_uploaded_file($tmpPath, $destFilePath) )
		{
			//append info about file to database
			$conn = connectToDB();
			$stmt = $conn->prepare("INSERT INTO uploaded_files VALUES(null, ?, ?, ?, ?)");
			$userId = ( isset($_SESSION['userId']) ) ? $_SESSION['userId'] : -1;
			$stmt->execute([ $userId, getClientIp(), time(), $destFilePath ]);

			//get id of inserted row
			$rowId = $conn->lastInsertId("id");
			//set download url
			$this->response['files'][$fileIndex]['url'] = DOWNLOAD_URL . '?id=' . $rowId;

			return true;
		}

		//error occured while moving the file
		//set error message
		$this->response['errors']['perFile'][$fileIndex] = "Plik nie został przesłany.<br/>Błąd: Nieudało się przenieść pliku z folderu tymczasowego na dysk.";

		return false;
	}

	//returns a file's path under which uploaded file will be stored
	//it preserves original file's name if a file with that name doesn't already exist in upload folder
	private function getDestFilePath($originalPath)
	{
		//get file's basename
		$basename = basename($originalPath);
		//get file's extension
		$ext = pathinfo($basename, PATHINFO_EXTENSION);
		//get file's name without extension
		$name = pathinfo($basename, PATHINFO_FILENAME);
		
		$targetFilePath = $this->uploadDir . $basename;
		//until file with that name exists append next numbers starting from 0 to file's name
		for ($i = 0 ; file_exists($targetFilePath) ; $i++)
			$targetFilePath = $this->uploadDir . $name . $i . '.' . $ext;

		return $targetFilePath;
	}
}

$upload = new Upload();
$upload->upload();
echo json_encode( $upload->getResponse() );
?>