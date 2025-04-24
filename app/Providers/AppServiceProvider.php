<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        ResetPassword::createUrlUsing(
            static fn(CanResetPassword $notifiable, string $token): string => sprintf(
                '%s/password-reset/%s?email=%s',
                Config::string('app.frontend_url'),
                $token,
                $notifiable->getEmailForPasswordReset(),
            ),
        );
    }
}
