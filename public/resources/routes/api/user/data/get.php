<?php
/*Returns data about current client's account
Returned json:
{
	//if one of following fields doesn't exists in db for client then field equals null
	user : {
		name
		surname
		email
		accountType
		ip
		storageUsedSize
	}
}
*/

require_once($phpPaths['PHP'] . '/user-data.php');
require_once($phpPaths['PHP'] . '/restrict-functions.php');
require_once($phpPaths['PHP'] . '/upload/storage.php');

startSession();
header('Content-type:application/json;charset=utf-8');

$userData = UserData::constructCurrentClient();
$storage = UserStorage::constructCurrentClient();
echo json_encode([ 'user' => array_merge( $userData->get(), 
	[ 'storageUsedSize' => $storage->getUsedSize() ] ) 
]);