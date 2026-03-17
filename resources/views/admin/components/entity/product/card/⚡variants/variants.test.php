<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\Variant;
use Livewire\Livewire;

it('renders successfully', function () {
    $product = new Product;

    Livewire::test('entity.product.card.variants', [
        'product' => $product,
    ])->assertStatus(200);
});

it('loads variants from product when no old input exists', function () {
    $product = Product::factory()
        ->has(Variant::factory()->count(2)->state(fn () => ['sort' => 1]), 'variants')
        ->create();

    $variants = $product->variants()
        ->orderBy('sort')
        ->get()
        ->map
        ->only(['id', 'name', 'sku', 'price', 'old_price', 'stock'])
        ->keyBy('id')
        ->toArray();

    Livewire::test('entity.product.card.variants', [
        'product' => $product,
    ])
        ->assertSet('variants', $variants);
});

it('initializes a single empty variant when product has none and no old input', function () {
    $product = Product::factory()->create();

    Livewire::test('entity.product.card.variants', [
        'product' => $product,
    ])
        ->assertCount('variants', 1)
        ->assertSet('showVariantName', false);
});

it('adds a variant when showVariantName is already true', function () {
    $product = Product::factory()->create();

    Livewire::test('entity.product.card.variants', [
        'product' => $product,
    ])
        ->set('variants', [
            'variant_1' => ['id' => 'variant_1', 'name' => 'A', 'sku' => '1', 'price' => 10, 'old_price' => null, 'stock' => 1],
            'variant_2' => ['id' => 'variant_2', 'name' => 'B', 'sku' => '2', 'price' => 20, 'old_price' => null, 'stock' => 2],
        ])
        ->set('showVariantName', true)
        ->call('addVariant')
        ->assertCount('variants', 3);
});

it('enables showVariantName when adding a second variant', function () {
    $product = Product::factory()->create();

    Livewire::test('entity.product.card.variants', [
        'product' => $product,
    ])
        ->set('variants', [
            'variant_1' => ['id' => 'variant_1', 'name' => null, 'sku' => null, 'price' => null, 'old_price' => null, 'stock' => null],
        ])
        ->set('showVariantName', false)
        ->call('addVariant')
        ->assertSet('showVariantName', true);
});

it('removes a variant', function () {
    $product = Product::factory()->create();

    Livewire::test('entity.product.card.variants', [
        'product' => $product,
    ])
        ->set('variants', [
            'variant_1' => ['id' => 'variant_1', 'name' => 'A', 'sku' => '1', 'price' => 10, 'old_price' => null, 'stock' => 1],
            'variant_2' => ['id' => 'variant_2', 'name' => 'B', 'sku' => '2', 'price' => 20, 'old_price' => null, 'stock' => 2],
        ])
        ->call('removeVariant', 'variant_1')
        ->assertSet('variants', [
            'variant_2' => ['id' => 'variant_2', 'name' => 'B', 'sku' => '2', 'price' => 20, 'old_price' => null, 'stock' => 2],
        ]);
});

it('disables showVariantName when removing last variant with name', function () {
    $product = Product::factory()->create();

    Livewire::test('entity.product.card.variants', [
        'product' => $product,
    ])
        ->set('variants', [
            'variant_1' => ['id' => 'variant_1', 'name' => 'A', 'sku' => '1', 'price' => 10, 'old_price' => null, 'stock' => 1],
        ])
        ->set('showVariantName', true)
        ->call('removeVariant', 'variant_1')
        ->assertSet('showVariantName', false);
});

it('reorders variants', function () {
    $product = Product::factory()->create();

    $variants = [
        'v1' => ['id' => 'v1', 'name' => 'A', 'sku' => '1', 'price' => 10, 'old_price' => null, 'stock' => 1],
        'v2' => ['id' => 'v2', 'name' => 'B', 'sku' => '2', 'price' => 20, 'old_price' => null, 'stock' => 2],
        'v3' => ['id' => 'v3', 'name' => 'C', 'sku' => '3', 'price' => 30, 'old_price' => null, 'stock' => 3],
    ];

    Livewire::test('entity.product.card.variants', [
        'product' => $product,
    ])
        ->set('variants', $variants)
        ->call('reorderVariants', ['v3', 'v1', 'v2'])
        ->assertSet('variants', [
            'v3' => $variants['v3'],
            'v1' => $variants['v1'],
            'v2' => $variants['v2'],
        ]);
});
