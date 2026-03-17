<?php

declare(strict_types=1);

use Livewire\Livewire;

it('renders successfully', function () {
    $product = new \App\Models\Product;

    Livewire::test('entity.product.card.main-information', [
        'product' => $product,
    ])->assertStatus(200);
});

it('loads product data into fields', function () {
    $brand = \App\Models\Brand::factory()->create();
    $categories = \App\Models\Category::factory()->count(2)->create();

    $product = \App\Models\Product::factory()
        ->hasAttached($categories)
        ->create([
            'name' => 'Test Product',
            'brand_id' => $brand->id,
            'active' => true,
            'featured' => false,
        ]);

    Livewire::test('entity.product.card.main-information', ['product' => $product])
        ->assertSet('name', 'Test Product')
        ->assertSet('brandId', (string) $brand->id)
        ->assertSet('active', true)
        ->assertSet('featured', false)
        ->assertSet('categories', $categories->pluck('id')->map(fn ($id) => (string) $id)->toArray());
});

it('dispatches name updated event when name changes', function () {
    $product = new \App\Models\Product;

    Livewire::test('entity.product.card.main-information', ['product' => $product])
        ->set('name', 'New Name')
        ->assertDispatched('entity.product.card.main-information.name.updated', name: 'New Name');
});

it('adds a new category input', function () {
    $product = new \App\Models\Product;

    Livewire::test('entity.product.card.main-information', ['product' => $product])
        ->set('categories', [1])
        ->call('addCategory')
        ->assertSet('categories', [1, null]);
});
