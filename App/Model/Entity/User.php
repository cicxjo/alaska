<?php

declare(strict_types = 1);

namespace App\Model\Entity;

class User
{
    public const TABLE = 'user';

    private int $id;
    private string $username;
    private string $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
