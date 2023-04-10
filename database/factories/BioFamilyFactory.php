<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BioFamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'parent_one' => fake()->name,
            'parent_two' => fake()->name,
            'phone' => fake()->phoneNumber,
            'email' => fake()->email,
        ];
    }
}
