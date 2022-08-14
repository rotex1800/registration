<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->words(asText: true),
            'start' => new Carbon(fake()->dateTime),
            'end' => new Carbon(fake()->dateTime)
        ];
    }

    public function default()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Unnamed Event',
                'start' => null,
                'end' => null,
            ];
        });
    }
}
