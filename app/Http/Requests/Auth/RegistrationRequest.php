<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\DataObjects\Auth\RegisterUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

final class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function payload(): RegisterUser
    {
        return new RegisterUser(
            name: $this->string('name')->toString(),
            email: $this->string('email')->toString(),
            password: Hash::make(
                value: $this->string('password')->toString(),
            ),
        );
    }
}
