<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => fake()->numberBetween(0, count(Document::TYPES) - 1),
            'is_required' => fake()->boolean(),
            'name' => fake()->word(),
            'owner_id' => User::factory(),
        ];
    }

    /**
     * Indicate the document is representing a digital file.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function digital()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Document::TYPES['digital'],
            ];
        });
    }
}