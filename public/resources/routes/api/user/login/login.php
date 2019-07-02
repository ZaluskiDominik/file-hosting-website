<?php

require_once($phpPaths['PHP'] . '/login.php');
startSession();

\Login\validateInput();

$userId = \Login\getUserIdByCredentials($_POST['email'], $_POST['password']);
if ($userId === null)
    die('Wrong email or password!');

//login to system
\Login\login($userId);

//redirect to previous page
header('location: ' . $_POST['prevPage']);