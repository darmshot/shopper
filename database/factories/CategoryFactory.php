<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'meta_title' => $this->faker->sentence(6),
            'meta_description' => $this->faker->text(160),
            'description' => $this->faker->paragraph(),
            'url' => $this->faker->unique()->slug(),
            'sort' => $this->faker->numberBetween(0, 4000000),
            'active' => $this->faker->boolean(),
        ];
    }
}
