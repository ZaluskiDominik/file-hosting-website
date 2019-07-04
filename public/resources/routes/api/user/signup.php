<?php
header('Content-type:application/json;charset=utf-8');

require_once($phpPaths['PHP'] . '/login.php');
require_once($phpPaths['PHP'] . '/signup.php');
require_once($phpPaths['PHP'] . '/signup-validation.php');
startSession();

//check if all post parameters were given
postParamsExist([ 'email', 'name', 'surname', 'password' ]);

//retrieve POST parameters and sanitize them against xss attack
$email = htmlspecialchars($_POST['email']);
$name = htmlspecialchars($_POST['name']);
$surname = htmlspecialchars($_POST['surname']);
$password = htmlspecialchars($_POST['password']);

//validate post parameters
$valid = new SignupValidation($email, $name, $surname, $password);
$valid->validate();

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