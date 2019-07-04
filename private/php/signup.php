<?php
namespace Signup;

require_once($phpPaths['PHP'] . '/db-connect.php');
require_once($phpPaths['PHP'] . '/ip-retriever.php');

//returs true if email already exists in users table
function emailExistsInDB(string $email)
{
    $db = connectToDB();
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([ $email ]);

    return ( $stmt->fetchColumn() ) ? true : false;
}

//sings up user, adds his/her data to users db table
//returns id of added user
function signup(string $email, string $name, string $surname, string $pass)
{
    $db = connectToDB();
    $stmt = $db->prepare("INSERT INTO users (password_hash, name, surname, email,
        account_type, ip) VALUES (?, ?, ?, ?, 'regular', ?)");
    //create password hash
    $passHash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt->execute([ $passHash, $name, $surname, $email, getClientIp() ]);

    return $db->lastInsertId();
}