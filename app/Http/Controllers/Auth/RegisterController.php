<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Jobs\Auth\CreateNewUser;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class RegisterController
{
    public function __construct(
        private Dispatcher $bus,
    ) {}

    public function __invoke(RegistrationRequest $request): Response
    {
        \Illuminate\Support\defer(
            callback: fn() => $this->bus->dispatch(
                command: new CreateNewUser(
                    payload: $request->payload(),
                ),
            ),
        );

        return new JsonResponse(
            data: [
                'message' => trans('auth.registering'),
            ],
            status: Response::HTTP_ACCEPTED,
        );
    }
}
