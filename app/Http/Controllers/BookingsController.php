<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingsSummaryRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;

class BookingsController extends Controller
{
    public function __construct(private readonly BookingService $bookingService) {
        $this->authorizeResource(Booking::class);
    }

    public function calendarInfo(BookingsSummaryRequest $request): JsonResponse
    {
        $data = $request->validated();

        $bookingOptions = $this->bookingService->getBookingOptionsByDates(Carbon::make($data['date_from']), Carbon::make($data['date_to']));

        return response()->json($bookingOptions);
    }

    public function index(): AnonymousResourceCollection
    {
        return BookingResource::collection(Booking::paginate());
    }

    public function store(StoreBookingRequest $request): BookingResource
    {
        $data = $request->validated();

        $booking = $this->bookingService->bookFromTo(Carbon::make($data['date_from']), Carbon::make($data['date_to']));

        return new BookingResource($booking);
    }

    public function show(Booking $booking): BookingResource
    {
        return new BookingResource($booking);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json(null, 204);
    }
}
