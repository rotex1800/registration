<?php

namespace Database\Factories;

use App\Models\CounselorInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CounselorInfoFactory extends Factory
{
    protected $model = CounselorInfo::class;

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
