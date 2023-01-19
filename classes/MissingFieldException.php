<?php

/**
 * And Error that the Form Field is Missing in the input
 */
class MissingFieldException extends \Exception
{
    public function __construct(string $field)
    {
        parent::__construct($this->generateMessage($field));
    }

    private function generateMessage(string $field): string
    {
        return "Missing field: " . $field;
    }
}