<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/config.php');
require_once($phpPaths['PHP'] . 'upload-validation.php');
require_once($phpPaths['PHP'] . 'db-manager.php');

class Upload
{
	private $response;

	public function __construct()
	{
		//get validation result
		$validation = new UploadValidation();
		$validation->validate();
		$this->response = $validation->getValidationResult();
		//add entry for uploaded files urls ad names
		$this->response['files'] = [];
	}

	//uploads files
	public function upload()
	{
		for ($i = 0 ; $i < count($_FILES['files']['size']) ; $i++)
		{
			$destPath = $this->getFilePath($_FILES['files']['name'][$i]);
			$this->saveFile($_FILES['files']['tmp_name'][$i], $destPath, $i);
		}

		$this->response['success'] = true;
	}

	public function getResponse()
	{
		return $this->response;
	}

	//moves uploaded files from temp location to disc
	private function saveFile($tmpPath, $destPath, $fileIndex)
	{
		$originalFileName = basename($_FILES['files']['name'][$fileIndex]);
		$uploadedFileName = basename($destPath);

		//!!!!!!!!!!!!!!!!!! MAKE IT WORK FOR ACCOUNT

		if ( move_uploaded_file($tmpPath, $destPath) )
		{
			$this->response['files'][] = [
				'url' => UPLOADED_URL . $uploadedFileName,
				'name' => $originalFileName
			];
		}
		else
		{
			$this->response['urls'][] = [
				'url' => "",
				'name' => $originalFileName
			];
			$this->response['errors']['perFile'][$fileIndex] = "Nieudało się przesłać pliku.";
		}
	}

	//returns a file's path under which it will be stored
	private function getFilePath($originalName)
	{
		if ( isset($_SESSION['userId']) )
		{
			$userData = ( DBManager($_SESSION['userId']) )->getUserData();
			$targetFile = UPLOAD_PATH . $userData['login'] . '\\' . basename($originalName);
		}
		else
			$targetFile = UPLOAD_PATH . basename($originalName);

		if ( file_exists($targetFile) )
		{
			for ($i = 0 ; file_exists($targetFile . $i) ; $i++);
			$targetFile .= $i;
		}

		return $targetFile;
	}
}

$upload = new Upload();
$upload->upload();
echo json_encode( $upload->getResponse() );
?>