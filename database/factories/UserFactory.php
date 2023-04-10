<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'family_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'birthday' => fake()->date,
            'gender' => fake()->randomElement(['female', 'male', 'na', 'diverse']),
            'mobile_phone' => fake()->phoneNumber,
            'health_issues' => fake()->paragraph,
            'email_verified_at' => now(),
            'uuid' => fake()->uuid,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function () {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Set the hash of the given plain text into as password
     */
    public function withPassword(string $plain): static
    {
        return $this->state(function () use ($plain) {
            return [
                'password' => Hash::make($plain),
            ];
        });
    }
}
