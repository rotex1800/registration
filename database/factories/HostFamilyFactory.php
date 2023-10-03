<?php

namespace Database\Factories;

use App\Models\HostFamily;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<HostFamily>
 *
 * @method HostFamily make($attributes = [], ?Model $parent = null)
 */
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
            // FIXME: The Newline inside the fake address is not properly dealt with in livewire assertions
//            'address' => fake()->address,
            'address' => fake()->words(asText: true),
            'phone' => fake()->e164PhoneNumber(),
            'order' => fake()->numberBetween(int1: 20, int2: 50),
        ];
    }

    public function first(): HostFamilyFactory
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
