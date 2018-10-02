<?php
//import database credentials
require_once($_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/config.php');

function &connectToDB()
{
	global $db;
	//open connection to database
	$conn = new PDO("mysql:host=" . $db['HOSTNAME'] . ";dbname=" . $db['NAME'] . ";charset=utf8", 
		$db['LOGIN'], $db['PASSWORD'], [
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]);
	
	return $conn;
}

function exceptionHandler($exception)
{
	if ($exception instanceof PDOException )
		die("Database error");
	else
		exit();
}

set_exception_handler("exceptionHandler");
?>