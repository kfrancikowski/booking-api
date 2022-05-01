<?php

namespace App\Rules;

use App\Models\Vacancy;
use Illuminate\Contracts\Validation\Rule;

class DateNotOccupiedForVacancy implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Vacancy::where('date_from', '<=', $value)
                ->where('date_to', '>=', $value)
                ->count() === 0;
    }

    public function message()
    {
        return __('validation.vacancy_already_occupied');
    }
}
