<?php
global $phpPaths;
require_once($phpPaths['PHP'] . '/signup.php');

class SignupTest extends PHPUnit\Framework\TestCase
{
    public function testEmailExistsInDBWhenExists()
    {
        $this->assertTrue( Signup\emailExistsInDB('marek@gmail.com') );
    }

    public function testEmailExistsInDBWhenNotExist()
    {
        $this->assertFalse( Signup\emailExistsInDB('nowy@gmail.com') );
    }
}