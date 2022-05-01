<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $uuid
 * @property Carbon $date_from
 * @property Carbon $date_to
 * @property float $price
 * @property int $number_of_vacancies
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from',
        'date_to',
        'price',
        'number_of_vacancies',
    ];

    protected $casts = [
        'uuid' => 'string',
        'date_from' => 'date',
        'date_to' => 'date',
        'number_of_vacancies' => 'integer',
        'price' => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
