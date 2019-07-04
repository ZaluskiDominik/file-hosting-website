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
        $this->validateEmail();
        $this->validateName();
        $this->validateSurname();
        $this->validatePassword();
    }

    //PRIVATE SECTION

    private $email;
    private $name;
    private $surname;
    private $password;

    //validates format of an email
    private function validateEmail()
    {
        if ( !filter_var($this->email, FILTER_VALIDATE_EMAIL) )
            notValid('email');
    }

    //validates whether name doesn't contain any whitespaces 
    private function validateName()
    {
        if (preg_match('/\s+/', $this->name))
            notValid('name');
    }

    //validates whether surname doesn't contain any whitespaces     
    private function validateSurname()
    {
        if (preg_match('/\s+/', $this->surname))
            notValid('surname');        
    }

    //validates whether password has at least 8 characters
    private function validatePassword()
    {
        if (strlen($this->password) < 8)
            notValid('password');
    }
}