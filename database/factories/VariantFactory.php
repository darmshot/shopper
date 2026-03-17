<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => $this->faker->unique()->ean8(),
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 0, 900000000),
            'old_price' => fn (array $attributes) => $this->faker->randomFloat(2, $attributes['price'], 900000000),
            'stock' => $this->faker->numberBetween(0, 4000000),
            'sort' => $this->faker->numberBetween(0, 4000000),
        ];
    }
}
