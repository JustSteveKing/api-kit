<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\Role as RoleAttribute;
use App\Enums\Rbac\Permission;
use App\Enums\Rbac\Role;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Role $role
 * @property string|null $remember_token
 * @property CarbonInterface|null $email_verified_at
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property CarbonInterface|null $deleted_at
 * @property Collection<int, ApiLog> $logs
 */
final class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasUlids;
    use Notifiable;
    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'remember_token',
        'email_verified_at',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(
            related: ApiLog::class,
            foreignKey: 'user_id',
        );
    }

    public function hasPermission(Permission $permission): bool
    {
        /** @var list<RoleAttribute> $roleAttributes */
        $roleAttributes = $permission->getAttributes(RoleAttribute::class);

        return array_any($roleAttributes, fn($roleAttribute) => in_array($this->role, $roleAttribute->roles, true));

    }

    /** @return array<string,string|class-string> */
    protected function casts(): array
    {
        return [
            'role' => Role::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
