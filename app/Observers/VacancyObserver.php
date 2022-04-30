<?php

namespace App\Observers;

use App\Models\Vacancy;
use Illuminate\Support\Str;

class VacancyObserver
{
    public function creating(Vacancy $vacancy): void
    {
        $vacancy->uuid = Str::uuid();
    }

}
