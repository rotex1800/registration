<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => fake()->numberBetween(0, 1),
            'is_required' => fake()->boolean(),
            'name' => fake()->word(),
            'path' => fake()->filePath(),
            'owner_id' => User::factory(),
            'state' => DocumentState::Approved,
        ];
    }

    /**
     * Indicate the document is representing a digital file.
     *
     * @return Factory
     */
    public function digital()
    {
        return $this->state(function () {
            return [
                'type' => Document::TYPE_DIGITAL,
            ];
        });
    }

    public function approved(): Factory
    {
        return $this->state(function () {
            return [
                'state' => DocumentState::Approved,
            ];
        });
    }

    public function declined(): Factory
    {
        return $this->state(function () {
            return [
                'state' => DocumentState::Declined,
            ];
        });
    }

    public function submitted(): Factory
    {
        return $this->state(function () {
            return [
                'state' => DocumentState::Submitted,
            ];
        });
    }

    public function withCategory(DocumentCategory $category)
    {
        return $this->state(function () use ($category) {
            return [
                'category' => $category->value,
            ];
        });
    }
}
