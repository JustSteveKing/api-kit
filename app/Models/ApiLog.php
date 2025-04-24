<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $request_id
 * @property string $method
 * @property string $url
 * @property int $status
 * @property int $time
 * @property array $request
 * @property array $response
 * @property string $token
 * @property string $user_id
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property null|User $user
 */
final class ApiLog extends Model
{
    use HasUlids;

    /** @var list<string> */
    protected $fillable = [
        'request_id',
        'method',
        'url',
        'status',
        'time',
        'request',
        'response',
        'token',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    /** @return array<string,string> */
    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'time' => 'integer',
            'request' => 'json',
            'response' => 'json',
            'token' => 'encrypted',
        ];
    }
}
