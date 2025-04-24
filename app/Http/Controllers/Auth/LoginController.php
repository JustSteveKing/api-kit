<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;
use Symfony\Component\HttpFoundation\Response;

final readonly class LoginController
{
    /**
     * @throws ValidationException
     */
    public function __invoke(LoginRequest $request): Response
    {
        $request->authenticate();

        /** @var NewAccessToken $token */
        $token = $request->user()?->createToken(
            name: 'API Access Token',
            abilities: ['*'],
        );

        return new JsonResponse(
            data: [
                'token' => $token->plainTextToken,
            ],
        );
    }
}
