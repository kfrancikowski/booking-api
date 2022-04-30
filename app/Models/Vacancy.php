<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from',
        'date_to',
        'price',
        'number_of_vacancies',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
