<?php

namespace Login;

require_once($phpPaths['PHP'] . '/restrict-functions.php');
require_once($phpPaths['PHP'] . '/db-connect.php');
require_once($phpPaths['PHP'] . '/user-data.php');

//checks if post parameters 'email', 'password', 'prevPage' are set
function validateInput()
{
    postParamsExist(['email', 'password', 'prevPage']);
}

//returns user id if user with given credentials was found
//else returns null
function getUserIdByCredentials(string $email, string $password)
{
    $db = connectToDB();
    //get password hash by searching email
    $stmt = $db->prepare("SELECT id, password_hash FROM users
        WHERE email = ?");
    $stmt->execute([ $email ]);
    $user = $stmt->fetch();

    //if no user with that email was found return null
    if ($user === false)
        return null;

    $hash = $user['password_hash'];
    //if hash and password are compatible return user id else null
    return ( password_verify($password, $hash) ) ? $user['id'] : null;
}

//login user to system
function login(int $userId)
{
    $user = \UserData::constructUserId($userId)->get();
    $_SESSION['user'] = [
        'id' => $userId,
        'email' => $user['email'],
        'name' => $user['name'],
        'surname' => $user['surname']
    ];
}

function logout()
{
    session_destroy();
}