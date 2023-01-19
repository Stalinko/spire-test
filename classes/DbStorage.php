<?php

interface DbStorage
{
    public function save(string $table, array $data): void;
}