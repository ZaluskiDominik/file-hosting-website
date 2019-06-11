<?php

//connects to db and returns PDO object
function connectToDB()
{
	global $dbConf;
	$db = new PDO("mysql:host=" . $dbConf['HOSTNAME'] . ";dbname=" . $dbConf['NAME'] 
		. ";charset=utf8", $dbConf['LOGIN'], $dbConf['PASSWORD'], [
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);
	
	return $db;
}