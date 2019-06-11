<?php
/*Returns data about user's account upload constraints 
Returned json:
{
	maxFileSize - max size of uploaded file(bytes)
	maxNum - max number of uploaded files at once
	maxStorageSize - max size of all uploaded files by client that can be stored on server(bytes)
}
*/

require_once($phpPaths['PHP'] . '/user-data.php');
require_once($phpPaths['PHP'] . '/account-data.php');
require_once($phpPaths['PHP'] . '/restrict-functions.php');

startSession();
header('Content-type:application/json;charset=utf-8');

$user = UserData::constructCurrentClient();
$account = new AccountData($user->get()['accountType']);

echo json_encode($account->getUploadConstraints());