<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class BookingService
{
    public function __construct(private readonly VacancyService $vacancyService) {}

    public function getBookingsCountForDate(Carbon $date): int
    {
        return Booking::where('date_from', '<=', $date)
            ->where('date_to', '>=', $date)
            ->count();
    }

    public function calculateBookingPriceForPeriod(Carbon $dateFrom, Carbon $dateTo): float
    {
        $date = clone $dateFrom;
        $total = 0;
        do {
            $vacancy = $this->vacancyService->getVacancyForDate($date);

            $total += $vacancy?->price ?? 0;
            $date->addDay();
        } while($date <= $dateTo);

        return $total;
    }

    public function getBookingOptionsByDates(Carbon $dateFrom, Carbon $dateTo): Collection
    {
        $vacanciesOptions = new Collection();

        $date = clone $dateFrom;
        do {
            $vacancy = $this->vacancyService->getVacancyForDate($date);

            $freeVacancies = $vacancy?->number_of_vacancies ? $vacancy->number_of_vacancies - $this->getBookingsCountForDate($date) : null;

            $vacanciesOptions->push([
                'date' => $date->format('Y-m-d'),
                'free_vacancies' => $freeVacancies,
                'price' => $vacancy->price ?? null
            ]);

            $date->addDay();
        } while($date <= $dateTo);

        return $vacanciesOptions;
    }

    public function bookFromTo(Carbon $dateFrom, Carbon $dateTo): Booking
    {
        return Booking::create([
            'user_id' => auth()->user()->id,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'price' => $this->calculateBookingPriceForPeriod($dateFrom, $dateTo)
        ]);
    }
}
