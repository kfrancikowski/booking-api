<?php

namespace Database\Factories;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dateFrom = $this->faker->dateTimeBetween('now', '+ 1 year');
        $dateTo = clone $dateFrom;
        $dateTo = $dateTo->modify('+10 days');
        $user = User::factory()->create(['role' => UserRoles::CLIENT]);

        return [
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to'   => $dateTo->format('Y-m-d'),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'user_id' => $user->id
        ];
    }
}
