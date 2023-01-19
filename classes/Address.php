<?php

class Address
{
    private string $address_line1;
    private string $address_line2;
    private string $state;
    private string $city;
    private string $zip;

    public function __construct(array $input)
    {
        $fields = [
            'address_line1',
            'address_line2',
            'state',
            'city',
            'zip',
        ];

        foreach ($fields as $field) {
            if (!isset($input[$field])) {
                throw new MissingFieldException($field);
            }

            $this->$field = $input[$field];
        }
    }

    public function getAddressLine1(): string
    {
        return $this->address_line1;
    }

    public function getAddressLine2(): string
    {
        return $this->address_line2;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function toArray(): array
    {
        return [
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'state' => $this->state,
            'zip' => $this->zip,
            'city' => $this->city,
        ];
    }
}