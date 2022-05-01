<?php

namespace App\Http\Requests;

use App\Rules\DateNotOccupiedForVacancy;
use Illuminate\Foundation\Http\FormRequest;

class StoreVacancyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_from' => ['required', 'date', 'after_or_equal:today', new DateNotOccupiedForVacancy()],
            'date_to' => ['required', 'date', 'after_or_equal:date_from', new DateNotOccupiedForVacancy()],
            'price' => ['required', 'numeric', 'min:0'],
            'number_of_vacancies' => ['required', 'integer', 'min:1'],
        ];
    }
}
