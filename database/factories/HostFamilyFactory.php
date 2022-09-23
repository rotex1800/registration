<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HostFamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->email,
            'phone' => fake()->phoneNumber,
        ];
    }
}
