<?php
set_time_limit(0);

require_once($phpPaths['PHP'] . '/download.php');
require_once($phpPaths['PHP'] . '/restrict-functions.php');
require_once($phpPaths['PHP'] . '/upload/storage.php');

//check if file parameter of GET is not empty
if (empty($_GET['file']))
    badRequest('No file given!');

//check if file exists
$file = UserStorage::getFileData($_GET['file']);
if ($file === null)
    die('File ' . $file['clientName'] . ' not found!');

$download = new Download();
//check if number of downloads limit wasn't exceeded
$timeToWait = 0;
if ( $download->isNumDownloadsLimitReached($timeToWait) )
    die('You have to wait ' . $timeToWait . ' seconds before download!');

$download->insertDownloadToDB($file['path']);

//output downloads headers
header('Content-Description: File Transfer');
header('Content-Type: ' . mime_content_type($file['path']));
header('Content-Disposition: attachment; filename="' . 
    basename($file['clientName']) . '"');
header('Content-Length: ' . filesize($file['path']));
header('Expires: 0');
header('Cache-Control: must-revalidate');
//flush headers
flush();

//if user has no limit to download speed then output all content of the file at once
if ($download->getMaxSpeed() === null)
{
    readfile($file['path']);
    exit();
}

//user has set limit to download speed
$fd = fopen($file['path'], 'r');

while (feof($fd) !== true)
{
    echo fread($fd, $download->getMaxSpeed() * 1024);
    sleep(1);
}

fclose($fd);