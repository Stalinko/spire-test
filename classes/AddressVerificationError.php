<?php

class AddressVerificationError extends \Exception
{
    public function __construct(string $message = 'Failed to verify the address')
    {
        parent::__construct($message);
    }
}