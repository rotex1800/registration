<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
        ];
    }

    /**
     * Indicate that the role is that of a Rotex member.
     */
    public function participant()
    {
        return $this->state(function () {
            return [
                'name' => 'participant',
            ];
        });
    }

    /**
     * Indicate that the role is that of a Rotex member.
     */
    public function rotex()
    {
        return $this->state(function () {
            return [
                'name' => 'rotex',
            ];
        });
    }
}
