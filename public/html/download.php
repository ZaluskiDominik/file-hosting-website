<?php
require_once($phpPaths['PHP'] . '/restrict-functions.php');
require_once($phpPaths['PHP'] . '/upload/storage.php');

//if file wasn't specified exit
if (empty($_GET['file']))
    badRequest('Nazwa pliku do pobrania nie została podana!');

//get data about a file(null if file doesn't exist)
$file = UserStorage::getFileData($_GET['file']);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once($phpPaths['TEMPLATES'] . "/head.php"); ?>
    <link rel="stylesheet" href="css/compare_accounts_table.css"/>
    <link rel="stylesheet" href="css/download.css">

    <script src="js/download.js"></script>
</head>

<body>
    <?php include($phpPaths['TEMPLATES'] . "/navbar.php"); ?>
    
    <?php
    //if file exists then display filename within bootstrap success alert
    if ($file !== null)
    {
        $filename = $file['clientName'];
        include($phpPaths['TEMPLATES'] . '/download/file-found.php');

        //display download button
        $downloadLink = $htmlPaths['API'] . '/file/download/get.php?file=' . 
            basename($file['path']);
        include($phpPaths['TEMPLATES'] . '/download/button.php');
    }
    //else display 'File not found' notification
    else
        include($phpPaths['TEMPLATES'] . '/download/file-not-found.php');
    ?>

    <div id="usedAllDownloadsAlert"class="alert alert-warning" role="alert">
        Pobranie pliku możliwe za <span></span>
    </div>

    <?php include($phpPaths['TEMPLATES'] . '/compare-accounts-table.php'); ?>
</body>

</html>