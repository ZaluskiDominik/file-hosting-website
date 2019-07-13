<?php
global $phpPaths;
require_once($phpPaths['PHP'] . '/user-data.php');

class UserDataTest extends PHPUnit\Framework\TestCase
{
    public function testGetUserDataByExistingUserId()
    {
        $user = UserData::constructUserId(8);
        $data = $user->get();

        $this->assertIsArray($data);
        
        $this->checkArrayHasKey($data);

        $this->assertEquals('Marek', $data['name']);
        $this->assertEquals('Nowak', $data['surname']);
        $this->assertEquals('marek@gmail.com', $data['email']);
        $this->assertEquals('regular', $data['accountType']);
        $this->assertEquals('127.0.0.1', $data['ip']);
    }

    public function testGetGuestUserData()
    {
        $user = UserData::constructCurrentClient();
        $data = $user->get();

        $this->assertIsArray($data);

        $this->checkArrayHasKey($data);

        $this->assertEquals(null, $data['name']);
        $this->assertEquals(null, $data['surname']);
        $this->assertEquals(null, $data['email']);
        $this->assertEquals('guest', $data['accountType']);
    }

    //PRIVATE FUCTION HELPERS

    private function checkArrayHasKey(array $userData)
    {
        $this->assertArrayHasKey('name', $userData);
        $this->assertArrayHasKey('surname', $userData);
        $this->assertArrayHasKey('email', $userData);
        $this->assertArrayHasKey('accountType', $userData);
        $this->assertArrayHasKey('ip', $userData);
    }
}