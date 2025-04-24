<?php

declare(strict_types=1);

namespace App\Enums\Rbac;

enum Role: string
{
    case Admin = 'admin';
    case User = 'user';
}
