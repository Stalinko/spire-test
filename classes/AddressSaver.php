<?php

class AddressSaver
{
    public function __construct(private readonly DbStorage $storage)
    {
    }

    public function save(Address $address): void
    {
        $this->storage->save('addresses', $address->toArray());
    }
}