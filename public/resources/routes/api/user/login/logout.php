<?php

require_once($phpPaths['PHP'] . '/login.php');
startSession();

//after logout user will be redirected to index page
$redirectPage = $htmlPaths['PAGES'] . '/index.php';
//if previous page was given as GET parameter set this url as redirection location
if (isset($_GET['prev_page']))
    $redirectPage = $_GET['prev_page'];

//destroy session
\Login\logout();
//redirect
header('location: ' . $redirectPage);