<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<HostFamily> */
class HostFamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->email,
            'address' => fake()->address,
            'phone' => fake()->phoneNumber,
            'order' => fake()->numberBetween(int1: 20, int2: 50),
        ];
    }

    public function first(): Factory
    {
        return $this->state(function () {
            return [
                'order' => 1,
            ];
        });
    }

    public function nth(int $n): HostFamilyFactory
    {
        return $this->state(function () use ($n) {
            return [
                'order' => $n,
            ];
        });
    }

    public function empty(): HostFamilyFactory
    {
        return $this->state(function () {
            return [
                'name' => '',
                'email' => '',
                'phone' => '',
                'address' => '',
                'order' => 0,
            ];
        });
    }
}
