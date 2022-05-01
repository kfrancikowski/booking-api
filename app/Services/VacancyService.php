<?php

namespace App\Services;

use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class VacancyService
{
    public function getVacancyForDate(Carbon $date): ?Vacancy
    {
        return Vacancy::where('date_from', '<=', $date)
            ->where('date_to', '>=', $date)
            ->first();
    }
}
