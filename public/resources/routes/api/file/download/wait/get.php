<?php
/*Returns json with info how much user have to wait before starting next download
JSON:
{
    mustWait
    secondsToWait
}
*/

require_once($phpPaths['PHP'] . '/restrict-functions.php');
require_once($phpPaths['PHP'] . '/download.php');

startSession();
header('Content-type:application/json;charset=utf-8');

$timeToWait = 0;
$wait = ( new Download() )->isNumDownloadsLimitReached($timeToWait);

echo json_encode([
    'mustWait' =>  $wait,
    'secondsToWait' => $timeToWait 
]);