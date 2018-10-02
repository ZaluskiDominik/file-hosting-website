<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/config.php');
require_once($phpPaths['PHP'] . 'db-manager.php');

//ends script with response(message and whether it's an error)
function endResp($msg, $errFlag)
{
	//if it's an error, set status code to error code
	if ($errFlag)
		http_response_code(400);
	die(json_encode([ 'msg' => $msg, 'error' => $errFlag ]));
}

//check if post var isn't empty
if ( empty($_FILES['file']) )
	endResp("Plik nie został wybrany", true);

//check if any error occured
if ( $_FILES['file']['error'] )
	endResp("Wystąpił błąd. Sprawdź czy wybrany plik nie przekracza maksymalnego rozmiaru.", true);

//destination path of uploaded file
$targetFile = UPLOAD_PATH . basename($_FILES["file"]["name"]);
//file size
$size = $_FILES['file']['size'];

//check if file already exists
if ( file_exists($targetFile) )
	endResp("Plik o podanej nazwie już istnieje.", true);

//validate file size
$dbManager = new DBManager( isset( $_SESSION['userId'] ) ? $_SESSION['userId'] : null );
$accountInfo = $dbManager->getAccountInfo();
if ( $size > $accountInfo['max_file_size'])
	endResp("Plik jest zbyt duży.", true);

if ( move_uploaded_file($_FILES['file']['tmp_name'], $targetFile) )
{
	//file uploaded successfully
	endResp("", false);
}

//an error occured
endResp("Wystąpił błąd. Spróbuj ponownie.", true);
?>