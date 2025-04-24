<?php

declare(strict_types=1);

namespace App\Jobs\Auth;

use App\Actions\Auth\CreateUserAction;
use App\DataObjects\Auth\RegisterUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class CreateNewUser implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly RegisterUser $payload,
    ) {}

    public function handle(CreateUserAction $action, Dispatcher $event): void
    {
        $user = $action->handle(
            payload: $this->payload,
        );

        $event->dispatch(
            event: new Registered(
                user: $user,
            ),
        );
    }
}
