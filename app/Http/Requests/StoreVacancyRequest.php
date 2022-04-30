<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacancyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_from' => ['required', 'date', 'after_or_equal:tomorrow'],
            'date_to' => ['required', 'date', 'after_or_equal:date_from'],
            'price' => ['required', 'numeric', 'min:0'],
            'number_of_vacancies' => ['required', 'integer', 'min:1'],
        ];
    }
}
