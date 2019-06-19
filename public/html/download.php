<?php
require_once($phpPaths['PHP'] . '/restrict-functions.php');
require_once($phpPaths['PHP'] . '/storage.php');

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

</head>
<body>
    <?php include($phpPaths['TEMPLATES'] . "/navbar.php"); ?>
    <h1></h1>
</body>
</html>