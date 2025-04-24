<?php

declare(strict_types=1);

namespace App\Enums\Rbac;

use App\Attributes\Description;
use App\Attributes\Role as RoleAttribute;
use App\Concerns\Rbac\HasAttributes;

enum Permission: string
{
    use HasAttributes;

    #[RoleAttribute(roles: [Role::Admin, Role::User])]
    #[Description('Allows deleting a user.')]
    case DeleteUser = 'users:delete';

    #[RoleAttribute(roles: [Role::Admin])]
    #[Description('Allows performing a super dangerous action.')]
    case PerformDangerousAction = 'action:dangerous';
}
