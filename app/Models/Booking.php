<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $uuid
 * @property int $user_id
 * @property Carbon $date_from
 * @property Carbon $date_to
 * @property float $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from',
        'date_to',
        'user_id',
        'price'
    ];

    protected $casts = [
        'uuid' => 'string',
        'date_from' => 'date',
        'date_to' => 'date',
        'price' => 'decimal:2'
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
