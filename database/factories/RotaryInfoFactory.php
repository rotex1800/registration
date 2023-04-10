<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RotaryInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'host_club' => fake()->words(asText: true),
            'host_district' => fake()->words(asText: true),
            'sponsor_club' => fake()->words(asText: true),
            'sponsor_district' => fake()->words(asText: true),
        ];
    }
}
