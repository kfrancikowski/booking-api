<?php

namespace App\Http\Requests;

use App\Rules\BookingDatesAvailable;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_from' => ['required', 'date', 'after_or_equal:today', new BookingDatesAvailable('date_to')],
            'date_to' => ['required', 'date', 'after_or_equal:date_from'],
        ];
    }
}
