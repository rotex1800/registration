<?php

namespace Database\Factories;

use App\Models\PersonInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonInfoFactory extends Factory
{
    protected $model = PersonInfo::class;

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
