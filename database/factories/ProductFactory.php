<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => $this->faker->unique()->slug(),
            'name' => $this->faker->words(3, true),
            'annotation' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'active' => $this->faker->boolean(),
            'meta_title' => $this->faker->sentence(6),
            'meta_description' => $this->faker->text(160),
            'featured' => $this->faker->boolean(),
        ];
    }
}
