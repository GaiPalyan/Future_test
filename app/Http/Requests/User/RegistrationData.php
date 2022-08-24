<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

class RegistrationData
{
    private string $name;
    private string $email;
    private string $hashed_password;

    public function __construct(string $name, string $email, string $hashed_password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->hashed_password = $hashed_password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return  $this->email;
    }

    public function getHash(): string
    {
        return $this->hashed_password;
    }
}
