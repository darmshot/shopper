<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::factory(10)->create();

        Category::factory(2)->create();
        Category::factory(2)
            ->for(Category::factory(), 'parent')
            ->create();

        Feature::factory()->create();

        Feature::factory(1)
            ->has(Category::factory()->state([
                'name' => 'Category with feature',
            ]), 'categories')
            ->create();

        Product::factory(3)->create();
    }
}
