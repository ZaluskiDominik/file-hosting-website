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
    $stmt = $db->prepare("SELECT id FROM users
        WHERE email = ? AND password_hash = ?");
    $stmt->execute([ $email, $password ]);
    $user = $stmt->fetch();

    return ( $user === false ) ? null : $user['id'];
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