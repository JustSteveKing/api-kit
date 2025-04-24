<?php

declare(strict_types=1);

namespace App\Attributes;

use App\Enums\Rbac\Role as RoleEnum;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT | Attribute::IS_REPEATABLE)]
final class Role
{
    public function __construct(public RoleEnum $role) {}
}
