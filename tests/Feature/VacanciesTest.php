<?php

namespace Tests\Feature;

use App\Enums\UserRoles;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class VacanciesTest extends TestCase
{
    public function testIndexAccess(): void
    {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);

        $this->get('/vacancies')->assertStatus(401);
        $this->actingAs($clientUser)->get('/vacancies')->assertStatus(403);
        $this->actingAs($adminUser)->get('/vacancies')->assertStatus(200);
    }

    public function testShowAccess(): void
    {
        $vacancy = Vacancy::factory()->create();
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);

        $this->get(route('vacancies.show', ['vacancy' => $vacancy]))->assertStatus(401);
        $this->actingAs($clientUser)->get(route('vacancies.show', ['vacancy' => $vacancy]))->assertStatus(403);
        $this->actingAs($adminUser)->get(route('vacancies.show', ['vacancy' => $vacancy]))->assertStatus(200);
    }

    public function testStoreAccess(): void
    {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);

        $this->post(route('vacancies.store'))->assertStatus(401);
        $this->actingAs($clientUser)->post(route('vacancies.store'))->assertStatus(403);
        $this->actingAs($adminUser)->post(route('vacancies.store'))->assertStatus(422);
    }

    public function testUpdateAccess(): void
    {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);
        $vacancy = Vacancy::factory()->create();

        $this->patch(route('vacancies.update', ['vacancy' => $vacancy]))->assertStatus(401);
        $this->actingAs($clientUser)->patch(route('vacancies.update', ['vacancy' => $vacancy]))->assertStatus(403);
        $this->actingAs($adminUser)->patch(route('vacancies.update', ['vacancy' => $vacancy]))->assertStatus(200);
    }

    public function testDestroyAccess(): void
    {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $clientUser = User::factory()->create([
            'role' => UserRoles::CLIENT
        ]);
        $vacancy = Vacancy::factory()->create();

        $this->delete(route('vacancies.destroy', ['vacancy' => $vacancy]))->assertStatus(401);
        $this->actingAs($clientUser)->delete(route('vacancies.destroy', ['vacancy' => $vacancy]))->assertStatus(403);
        $this->actingAs($adminUser)->delete(route('vacancies.destroy', ['vacancy' => $vacancy]))->assertStatus(204);
    }

    public function testStore(): void {
        Vacancy::truncate();

        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);

        $this->actingAs($adminUser)->post(route('vacancies.store'), [
            'date_from' => Carbon::now()->format('Y-m-d'),
            'date_to' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'price' => 19.99,
            'number_of_vacancies' => -5
        ])->assertStatus(422);

        $this->actingAs($adminUser)->post(route('vacancies.store'), [
            'date_from' => Carbon::now()->format('Y-m-d'),
            'date_to' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'price' => 19.99,
            'number_of_vacancies' => 4
        ])->assertStatus(201);
    }

    public function testUpdate(): void {
        $adminUser = User::factory()->create([
            'role' => UserRoles::ADMIN
        ]);
        $vacancy = Vacancy::factory()->create();

        $this->actingAs($adminUser)->patch(route('vacancies.update', ['vacancy' => $vacancy]), [
            'number_of_vacancies' => -5
        ])->assertStatus(422);

        $this->actingAs($adminUser)->patch(route('vacancies.update', ['vacancy' => $vacancy]), [
            'number_of_vacancies' => 10
        ])->assertStatus(200);
    }
}
