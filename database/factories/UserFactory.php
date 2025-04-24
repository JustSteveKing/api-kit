<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Rbac\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @extends Factory<User> */
final class UserFactory extends Factory
{
    /** @var class-string<User> */
    protected $model = User::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => Role::User,
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ];
    }
}
