<?php

namespace Database\Factories;

use App\Models\ClothesSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdditionalInfo>
 */
class AdditionalInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tshirt_size' => fake()->randomElement(ClothesSize::cases()),
            'allergies' => fake()->text,
            'user_id' => fake()->randomNumber(),
            'diet' => fake()->words(asText: true),
            'note' => fake()->text,
            'desired_group' => fake()->text,
        ];
    }
}
