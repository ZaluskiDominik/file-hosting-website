<?php
header('Content-type:application/json;charset=utf-8');

require_once($phpPaths['PHP'] . '/login.php');
require_once($phpPaths['PHP'] . '/signup.php');
startSession();





//retrieve POST parameters
$email = $_POST['email'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$password = $_POST['password'];

//if given email already exists in db, don't proceed with signu up
//returns json with info that account couldn't be created
if ( \Signup\emailExistsInDB($email) )
{
    echo json_encode([ 'emailInUse' => true ]);
    exit();
}

//register new account
$userId = \Signup\signup($email, $name, $surname, $password);

//login to system
\Login\login($userId);

echo json_encode([ 'emailInUse' => false ]);