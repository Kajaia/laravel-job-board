<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobVacancyResponse>
 */
class JobVacancyResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vacancy_id' => fake()->numberBetween(1, 100),
            'user_id' => fake()->numberBetween(1, 10)
        ];
    }
}
