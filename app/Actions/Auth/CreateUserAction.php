<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\DataObjects\Auth\RegisterUser;
use App\Models\User;
use Illuminate\Database\DatabaseManager;

final readonly class CreateUserAction
{
    public function __construct(
        private DatabaseManager $database,
    ) {}

    public function handle(RegisterUser $payload): User
    {
        return $this->database->transaction(
            callback: fn() => User::query()->create(
                attributes: $payload->toArray(),
            ),
            attempts: 3,
        );
    }
}
