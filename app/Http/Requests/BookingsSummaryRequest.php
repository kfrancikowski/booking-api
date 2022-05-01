<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingsSummaryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_from' => ['required', 'date', 'after_or_equal:today'],
            'date_to' => ['required', 'date', 'after_or_equal:date_from'],
        ];
    }
}
