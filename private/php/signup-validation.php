<?php
require_once($phpPaths['PHP'] . '/restrict-functions.php');

class SignupValidation
{
    public function __construct($email, $name, $surname, $pass)
    {
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $pass;
    }

    //validates all parameters passed via constructor
    //if any of them won't pass validation script is exited and http 400 code is
    //returned
    public function validate()
    {
        if ( !$this->validateEmail($this->email) )
            notValid('email');            
        if ( !$this->validateNameOrSurname($this->name) )
            notValid('name');
        if ( !$this->validateNameOrSurname($this->surname) )
            notValid('surname');        
        if ( !$this->validatePassword($this->password) )
            notValid('password');
    }

    //validates format of an email
    public static function validateEmail($email)
    {
        return is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //validates whether name or surname doesn't contain any whitespaces and length < 50
    public static function validateNameOrSurname($nameOrSurname)
    {
        return is_string($nameOrSurname) && !preg_match('/\s+/', $nameOrSurname)
            && strlen($nameOrSurname) < 50;
    }

    //validates whether password has at least 8 characters and < 30
    public static function validatePassword($password)
    {
        return is_string($password) && strlen($password) >= 8
            && strlen($password) < 30;
    }

    //PRIVATE SECTION

    private $email;
    private $name;
    private $surname;
    private $password;
}