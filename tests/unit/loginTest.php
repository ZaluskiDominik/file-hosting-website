<?php
global $phpPaths;
require_once($phpPaths['PHP'] . '/login.php');

class LoginTest extends PHPUnit\Framework\TestCase
{
    //tests if id of user will be returned when credentials for that user exists in db
    public function testGetUserIdByCredentialsWhenUserExist()
    {
        $userId = Login\getUserIdByCredentials('marek@gmail.com', 'password');
        $this->assertEquals(8, $userId);

        $userId = Login\getUserIdByCredentials('kamil.konieczny@wp.pl', 'password2');
        $this->assertEquals(9, $userId);
    }

    //tests if null will be returned when credentials for user doesn't exist in db
    //login valid, password - wrong
    public function testGetUserIdByCredentialsWhenUserNotExistValidLogin()
    {
        $userId = Login\getUserIdByCredentials('marek@gmail.com', 'pass');
        $this->assertNull($userId);        
    }

    //login wrong, password - valid
    public function testGetUserIdByCredentialsWhenUserNotExistValidPassword()
    {
        $userId = Login\getUserIdByCredentials('adam@gmail.com', 'password');
        $this->assertNull($userId);        
    }
    
    //both login and password invalid
    public function testGetUserIdByCredentialsWhenUserNotExistBothInvalid()
    {
        $userId = Login\getUserIdByCredentials('adam@wp.pl', 'acacca');
        $this->assertNull($userId);        
    }
}