<?php

declare(strict_types=1);

namespace App\DataObjects\Auth;

final readonly class RegisterUser
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
