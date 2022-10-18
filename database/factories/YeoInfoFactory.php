<?php

namespace Database\Factories;

use App\Models\YeoInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class YeoInfoFactory extends Factory
{
    protected $model = YeoInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, string>
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
