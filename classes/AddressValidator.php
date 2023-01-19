<?php

class AddressValidator
{
    public function __construct(
        private readonly UspsApi $uspsApi
    )
    {
    }

    /**
     * @param Address $address
     * @return Address
     * @throws AddressVerificationError
     */
    public function validate(Address $address): Address
    {
        $response = $this->uspsApi->verifyAddress($address);
        return $this->uspsApi->parseResponse($response);
    }
}