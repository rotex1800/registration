<?php

namespace Database\Factories;

use App\Models\ClothesSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClothesInfo>
 */
class ClothesInfoFactory extends Factory
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
            'user_id' => fake()->randomNumber(),
        ];
    }
}
