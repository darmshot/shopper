<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'url' => $this->faker->unique()->slug(),
            'meta_title' => $this->faker->sentence(6),
            'meta_description' => $this->faker->realText(200),
            'description' => $this->faker->realText(200),
        ];
    }
}
