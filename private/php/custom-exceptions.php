<?php

class MoveUploadedFileException extends exception
{
    public function __construct(string $fileName)
    {
        parent::__construct("Couldn't move uploaded file named '" .
            $fileName . "' from temporary directory");
    }
}

class UndefinedTemplateContentVar extends exception
{
    public function __construct(string $varName)
    {
        parent::__construct("Template variable '" .
            $varName . "' is undefined!");
    }
}