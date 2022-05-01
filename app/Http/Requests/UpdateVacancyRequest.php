<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVacancyRequest extends FormRequest
{
    public function rules()
    {
        return [
//            'date_from' => ['required_if:date_to', 'date', 'after_or_equal:tomorrow'],
//            'date_to' => ['required_if:date_from', 'date', 'after_or_equal:date_from'],
            'price' => ['numeric', 'min:0'],
            'number_of_vacancies' => ['integer', 'min:1'],
        ];
    }
}
