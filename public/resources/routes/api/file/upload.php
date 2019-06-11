<?php
/*Uploads files to server
Returns json:
{
    clientName - name of a file on client machine
    serverName - name of the same file on server side
    errorId - id of an error(0 if no errors) else one of following:
        //1 - error occured
        //2 - one of upload constraint wasn't mached
    errorMsg - errorr message content if error occured
}
params:
files - array of files to upload that will be accessible via $_FILES superglobal
*/

require_once($phpPaths['PHP'] . '/restrict-functions.php');
require_once($phpPaths['PHP'] . '/upload/upload-handler.php');

startSession();

//if no file were uplaoded end script
if ( empty($_FILES['files']) )
    badRequest('No file were uploaded!');

$upload = new UploadHandler($_FILES['files'], $phpPaths['UPLOADED_FILES']);
$upload->upload();

$uploadSummary = $upload->getSummary();

echo json_encode($uploadSummary);