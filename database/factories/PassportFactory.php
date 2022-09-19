<?php

namespace Database\Factories;

use App\Models\Passport;
use Illuminate\Database\Eloquent\Factories\Factory;

class PassportFactory extends Factory
{
    protected $model = Passport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'nationality' => fake()->country,
            'passport_number' => fake()->words(asText: true),
            'issue_date' => fake()->date,
            'expiration_date' => fake()->date,
        ];
    }
}
