<?php

startSession();
header('Content-type:application/json;charset=utf-8');

require_once($phpPaths['PHP'] . '/login.php');

//validate POST input
\Login\validateInput();

$found = false;
if (\Login\getUserIdByCredentials($_POST['email'], $_POST['password']) !== null)
    $found = true;

echo json_encode([
    'valid' => $found
]);