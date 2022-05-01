<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dateFrom = $this->faker->dateTimeBetween('now', '+30 days');
        $dateTo = clone $dateFrom;
        $dateTo = $dateTo->modify('+10 days');

        return [
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to'   => $dateTo->format('Y-m-d'),
            'number_of_vacancies' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 1, 100)
        ];
    }
}
