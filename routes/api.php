<?php

use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\VacanciesController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('issue-token', [TokenController::class, 'issueToken']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/me', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::apiResource('vacancies', VacanciesController::class);
    Route::apiResource('bookings', BookingsController::class)->except('update');
});


Route::name('bookings.')->prefix('bookings')->group(function() {
    Route::post('calendar-info', [BookingsController::class, 'calendarInfo'])->name('calendar-info');
});

require __DIR__.'/auth.php';

