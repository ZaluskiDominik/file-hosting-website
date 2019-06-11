<?php
/*Returns data about user's account download constraints 
Returned json:
{
	maxSpeed - maximal speed of download(Kb/s)
	maxNum - maximal number of downloads during maxNumDuration period of time
	maxNumDuration - duration period(seconds) after which number of downloads resets(so user can
	start another one) 
}
*/

require_once($phpPaths['PHP'] . '/user-data.php');
require_once($phpPaths['PHP'] . '/account-data.php');
require_once($phpPaths['PHP'] . '/restrict-functions.php');

startSession();
header('Content-type:application/json;charset=utf-8');

$user = UserData::constructCurrentClient();
$account = new AccountData($user->get()['accountType']);

echo json_encode( array_merge($account->getDownloadConstraints(), [
	'maxNumDuration' => $downloadConf['MAX_NUM_DURATION']
]) );