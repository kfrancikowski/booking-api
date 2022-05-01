<?php

namespace App\Rules;

use App\Models\Vacancy;
use App\Services\BookingService;
use App\Services\VacancyService;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class BookingDatesAvailable implements Rule
{
    private string $errorMessage;
    private BookingService $bookingService;

    public function __construct(private readonly string $dateToField) {
        $this->errorMessage = __('validation.booking_dates_are_not_available');
        $this->bookingService = app(BookingService::class);
    }

    public function passes($attribute, $dateFrom): bool
    {
        $dateTo = request()->input($this->dateToField);

        if(empty($dateTo)) {
            $this->errorMessage = __('validation.booking_dates_field_cannot_be_empty');
            return false;
        }

        $bookingOptions = $this->bookingService->getBookingOptionsByDates(Carbon::make($dateFrom), Carbon::make($dateTo));

        return $bookingOptions->first()['date'] === $dateFrom &&
            $bookingOptions->last()['date'] === $dateTo &&
            $bookingOptions->where('free_vacancies', '=', 0)->count() === 0;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}
