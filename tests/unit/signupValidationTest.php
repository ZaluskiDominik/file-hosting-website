<?php
global $phpPaths;
require_once($phpPaths['PHP'] . '/signup-validation.php');

class SignupValidationTest extends PHPUnit\Framework\TestCase
{
    public function testEmailValidation()
    {
        $this->assertTrue( SignupValidation::validateEmail('john.smith@domain.com') );
        $this->assertTrue( SignupValidation::validateEmail('smith@d.pl') );
        $this->assertFalse( SignupValidation::validateEmail(123) );
        $this->assertFalse( SignupValidation::validateEmail('john.smithdomain.com') );
        $this->assertFalse( SignupValidation::validateEmail('john@com') );
        $this->assertFalse( SignupValidation::validateEmail('john@example.') );
        $this->assertFalse( SignupValidation::validateEmail('@example.de') );
    }

    public function testPasswordValidation()
    {
        $this->assertTrue( SignupValidation::validatePassword('new password') );
        $this->assertTrue( SignupValidation::validatePassword('password') );
        $this->assertTrue( SignupValidation::validatePassword(
            'bbbbbbbbbbbbbbbbbbbbbbbbbb') );
        $this->assertFalse( SignupValidation::validatePassword('passwor') );
        $this->assertFalse( SignupValidation::validatePassword('') );
        $this->assertFalse( SignupValidation::validatePassword(123) );
        $this->assertFalse( SignupValidation::validatePassword(
            'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbb') );
    }

    public function testNameOrSurnameValidation()
    {
        $this->assertTrue( SignupValidation::validateNameOrSurname('Nowak') );
        $this->assertFalse( SignupValidation::validateNameOrSurname(10) );        
        $this->assertFalse( SignupValidation::validateNameOrSurname('Nowak ') );        
        $this->assertFalse( SignupValidation::validateNameOrSurname('Nowak Smith') );
    }
}