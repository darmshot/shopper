<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use Livewire\Livewire;

it('renders successfully', function () {
    $product = new Product;

    Livewire::test('entity.product.card.product-properties', [
        'product' => $product,
    ])->assertStatus(200);
});

it('loads features based on main category', function () {
    $category = Category::factory()->create();

    $featureA = Feature::factory()->create();
    $featureB = Feature::factory()->create();

    // Attach features to category (Feature side)
    $featureA->categories()->attach($category->id);
    $featureB->categories()->attach($category->id);

    $product = Product::factory()
        ->hasAttached($category)
        ->create();

    Livewire::test('entity.product.card.product-properties', [
        'product' => $product,
    ])
        ->assertSet('mainCategoryId', $category->id)
        ->assertSee($featureA->name)
        ->assertSee($featureB->name);
});

it('initializes options for each feature', function () {
    $category = Category::factory()->create();
    $feature = Feature::factory()->create();

    $feature->categories()->attach($category->id);

    $product = Product::factory()
        ->hasAttached($category)
        ->create();

    Livewire::test('entity.product.card.product-properties', [
        'product' => $product,
    ])
        ->assertSet('options.0.feature_id', $feature->id)
        ->assertSet('options.0.value', null);
});

it('adds a new feature row', function () {
    $product = new Product;

    Livewire::test('entity.product.card.product-properties', [
        'product' => $product,
    ])
        ->call('addNewFeature')
        ->assertSet('newFeatures.0.0.name', null)
        ->assertSet('newFeatures.0.0.value', null);
});

it('removes a new feature row and reindexes array', function () {
    $product = new Product;

    Livewire::test('entity.product.card.product-properties', [
        'product' => $product,
    ])
        ->set('newFeatures', [
            ['name' => 'A', 'value' => '1'],
            ['name' => 'B', 'value' => '2'],
        ])
        ->call('removeNewFeature', 0)
        ->assertSet('newFeatures', [
            ['name' => 'B', 'value' => '2'],
        ]);
});

it('updates features when main category changes', function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();

    $feature1 = Feature::factory()->create();
    $feature2 = Feature::factory()->create();

    // Attach features to categories
    $feature1->categories()->attach($category1->id);
    $feature2->categories()->attach($category2->id);

    $product = Product::factory()
        ->hasAttached($category1)
        ->create();

    Livewire::test('entity.product.card.product-properties', [
        'product' => $product,
    ])
        ->assertSee($feature1->name)
        ->set('mainCategoryId', $category2->id)
        ->assertDontSee($feature1->name)
        ->assertSee($feature2->name);
});
