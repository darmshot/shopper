<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Admin;

use App\Http\Controllers\Admin\FeatureController;
use App\Models\Category;
use App\Models\Feature;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('store feature. full valid form', function (array $attributes) {
    $categories = Category::factory()->createMany(1);

    $response = post(action([FeatureController::class, 'store']), [
        ...$attributes,
        'categories' => $categories->pluck('id')->toArray(),
    ]);

    $response->assertValid();

    $response->assertRedirect();

    assertDatabaseHas('features', [
        'name' => $attributes['name'],
    ]);

    assertDatabaseCount('category_feature', 1);
    assertDatabaseCount('features', 1);
})
    ->with('feature raw attributes');

test('update feature. full valid form', function (array $attributes) {
    $feature = Feature::factory()
        ->has(Category::factory()->count(2), 'categories')
        ->create();
    $categories = Category::factory()->createMany(1);

    $response = put(action([FeatureController::class, 'update'], ['feature' => $feature->id]), [
        ...$attributes,
        'categories' => [
            $feature->categories->first()->id,
            ...$categories->pluck('id')->toArray(),
        ],
    ]);

    $response->assertValid();

    $response->assertRedirect();

    assertDatabaseHas('features', [
        'name' => $attributes['name'],
    ]);

    assertDatabaseCount('category_feature', 2);
})
    ->with('feature raw attributes');
