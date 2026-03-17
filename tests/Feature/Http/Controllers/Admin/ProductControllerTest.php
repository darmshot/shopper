<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ProductController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Option;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('store product. full valid form', function (array $attributes, array $variantAttributes) {
    $brand = Brand::factory()->create();
    $products = Product::factory()->createMany(2);
    $categories = Category::factory()->createMany(1);
    $features = Feature::factory()->createMany(2);

    $response = post(action([ProductController::class, 'store']), [
        ...$attributes,
        'brand_id' => $brand->id,
        'related' => $products->pluck('id')->toArray(),
        'variants' => [
            $variantAttributes,
            [...$variantAttributes, 'name' => 'samsung 2', 'sku' => 'SKU 2'],
        ],
        'options' => $features->map(function (Feature $feature, int $key) {
            return ['feature_id' => $feature->id, 'value' => "value $key"];
        })->toArray(),
        'new_features' => [
            ['name' => 'New feature', 'value' => 'Value of my feature'],
        ],
        'categories' => $categories->pluck('id')->toArray(),
        'dropped_images' => [
            UploadedFile::fake()->image('photo1.jpg')->size(256),
            UploadedFile::fake()->image('photo2.jpg')->size(256),
        ],
        'not_exists_field' => 'value',
    ]);

    $response->assertValid();

    $response->assertRedirect();

    $product = Product::query()
        ->where('url', $attributes['url'])
        ->first();

    assertDatabaseHas('products', [
        'brand_id' => $brand->id,
        'name' => $attributes['name'],
    ]);

    expect($product?->brand_id)
        ->toBe($brand->id)
        ->and($product?->name)->toBe($attributes['name'])
        ->and($product?->images)->toHaveCount(2);

    assertDatabaseCount('product_related', 2);
    assertDatabaseCount('variants', 2);
    assertDatabaseCount('options', 3);
    assertDatabaseCount('categories', 1);
})
    ->with('product fillable attributes')
    ->with('variant fillable attributes');

test('update product. full valid form', function (array $attributes, array $variantAttributes) {
    /** @var array<\Illuminate\Http\Testing\File> $images */
    $images = [
        UploadedFile::fake()->image('photo1.jpg')->size(256),
        UploadedFile::fake()->image('photo2.jpg')->size(256),
    ];

    $product = Product::factory()
        ->state([
            'images' => array_map(fn (\Illuminate\Http\Testing\File $file) => $file->path(), $images),
        ])
        ->for(Brand::factory(), 'brand')
        ->has(Variant::factory()->count(2), 'variants')
        ->has(Category::factory()->count(2), 'categories')
        ->has(Product::factory()->count(2), 'related')
        ->has(Option::factory()->state([
            'feature_id' => fn () => Feature::factory()->create(),
        ])->count(2), 'options')
        ->create();

    $brand = Brand::factory()->create();
    $related = Product::factory()->createMany(2);
    $categories = Category::factory()->createMany(1);

    $response = put(action([ProductController::class, 'update'], ['product' => $product->id]), [
        ...$attributes,
        'brand_id' => $brand->id,
        'related' => [
            $product->related->first()->id,
            ...$related->pluck('id')->toArray(),
        ],
        'variants' => [
            $product->variants->first()->only(['sku', 'price', 'old_price']),
            $variantAttributes,
            [...$variantAttributes, 'name' => 'samsung 2', 'sku' => 'SKU 2'],
        ],
        'options' => [
            $product->options->first()->only(['feature_id', 'value']),
            $product->options->get(1)->only('feature_id'),
        ],
        'new_features' => [
            ['name' => 'New feature', 'value' => 'Value of my feature'],
        ],
        'categories' => [
            $product->categories->first()->id,
            ...$categories->pluck('id')->toArray(),
        ],
        'deleted_images' => [
            $images[1]->path(),
        ],
        'dropped_images' => [
            UploadedFile::fake()->image('photo1.jpg')->size(256),
            UploadedFile::fake()->image('photo2.jpg')->size(256),
        ],
        'not_exists_field' => 'value',
    ]);

    $response->assertValid();

    $response->assertRedirect();

    $product = Product::query()
        ->where('url', $attributes['url'])
        ->first();

    assertDatabaseHas('products', [
        'brand_id' => $brand->id,
        'name' => $attributes['name'],
    ]);

    expect($product?->brand_id)
        ->toBe($brand->id)
        ->and($product?->name)->toBe($attributes['name'])
        ->and($product?->images)->toHaveCount(3);

    assertDatabaseCount('product_related', 3);
    assertDatabaseCount('variants', 3);
    assertDatabaseCount('options', 2);
    assertDatabaseCount('category_product', 2);
})
    ->with('product fillable attributes')
    ->with('variant fillable attributes');
