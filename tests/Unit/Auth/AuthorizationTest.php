<?php

declare(strict_types=1);

namespace Tests\Models;

use App\Enums\Rbac\Permission;
use App\Enums\Rbac\Role;
use App\Models\User;

describe('authorization tests', function (): void {
    test('user with Admin role has permission for DeleteUser', function () {
        $user = new User(['role' => Role::Admin]);

        $permission = Permission::DeleteUser;

        expect($user->hasPermission($permission))->toBeTrue();
    });

    test('user with User role has permission for DeleteUser', function () {
        $user = new User(['role' => Role::User]);

        $permission = Permission::DeleteUser;

        expect($user->hasPermission($permission))->toBeTrue();
    });

    test('user with Admin role has permission for PerformDangerousAction', function () {
        $user = new User(['role' => Role::Admin]);

        $permission = Permission::PerformDangerousAction;

        expect($user->hasPermission($permission))->toBeTrue();
    });

    test('user with User role does not have permission for PerformDangerousAction', function () {
        $user = new User(['role' => Role::User]);

        $permission = Permission::PerformDangerousAction;

        expect($user->hasPermission($permission))->toBeFalse();
    });
});
