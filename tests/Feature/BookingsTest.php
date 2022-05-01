<?php

namespace Tests\Feature;

use App\Enums\UserRoles;
use App\Models\Booking;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BookingsTest extends TestCase
{
    public function testIndexAccess(): void
    {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);

        $this->get(route('bookings.index'))->assertStatus(401);
        $this->actingAs($clientUser)->get(route('bookings.index'))->assertStatus(403);
        $this->actingAs($adminUser)->get(route('bookings.index'))->assertStatus(200);
    }

    public function testCalendarInfoAccess(): void
    {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);

        $this->post(route('bookings.calendar-info'))->assertStatus(422);
        $this->actingAs($clientUser)->post(route('bookings.calendar-info'))->assertStatus(422);
        $this->actingAs($adminUser)->post(route('bookings.calendar-info'))->assertStatus(422);
    }

    public function testShowAccess(): void
    {
        $booking = Booking::factory()->create();
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);

        $this->get(route('bookings.show', ['booking' => $booking]))->assertStatus(401);
        $this->actingAs($clientUser)->get(route('bookings.show', ['booking' => $booking]))->assertStatus(403);
        $this->actingAs($adminUser)->get(route('bookings.show', ['booking' => $booking]))->assertStatus(200);
    }

    public function testStoreAccess(): void
    {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);

        $this->post(route('bookings.store'))->assertStatus(401);
        $this->actingAs($clientUser)->post(route('bookings.store'))->assertStatus(422);
        $this->actingAs($adminUser)->post(route('bookings.store'))->assertStatus(403);
    }

    public function testDestroyAccess(): void
    {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);
        $booking = Booking::factory()->create();

        $this->delete(route('bookings.destroy', ['booking' => $booking]))->assertStatus(401);
        $this->actingAs($clientUser)->delete(route('bookings.destroy', ['booking' => $booking]))->assertStatus(204);
        $this->actingAs($adminUser)->delete(route('bookings.destroy', ['booking' => $booking]))->assertStatus(204);
    }

    public function testStore(): void
    {
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);

        $vacancy = Vacancy::factory()->create();

        $this->actingAs($clientUser)->post(route('bookings.store'), [
            'date_from' => $vacancy->date_from->addDays(2),
            'date_to' =>$vacancy->date_from->addDays(5)
        ])->assertStatus(200);
    }
}
