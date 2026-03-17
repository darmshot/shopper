<?php

declare(strict_types=1);

use App\Models\Product;
use Livewire\Livewire;

it('renders successfully', function () {
    $product = new Product;

    Livewire::test('entity.shared.card.page-parameters', [
        'entity' => $product,
        'urlPrefix' => '/products/',
    ])->assertStatus(200);
});

it('loads product data into fields', function () {
    $product = Product::factory()->create([
        'name' => 'Test Product',
        'url' => 'test-product',
        'meta_title' => 'Meta Title',
        'meta_description' => 'Meta Description',
    ]);

    Livewire::test('entity.shared.card.page-parameters', [
        'entity' => $product,
        'urlPrefix' => '/products/',
    ])
        ->assertSet('name', 'Test Product')
        ->assertSet('url', 'test-product')
        ->assertSet('metaTitle', 'Meta Title')
        ->assertSet('metaDescription', 'Meta Description');
});

it('auto-generates url and metaTitle when name changes', function () {
    $product = new Product;

    Livewire::test('entity.shared.card.page-parameters', [
        'entity' => $product,
        'urlPrefix' => '/products/',
    ])
        ->set('name', 'New Product Name')
        ->assertSet('url', 'new-product-name')
        ->assertSet('metaTitle', 'New Product Name');
});

it('does not override url or metaTitle if already set', function () {
    $product = new Product;

    Livewire::test('entity.shared.card.page-parameters', [
        'entity' => $product,
        'urlPrefix' => '/products/',
    ])
        ->set('url', 'custom-url')
        ->set('metaTitle', 'Custom Title')
        ->set('name', 'Another Name')
        ->assertSet('url', 'custom-url')
        ->assertSet('metaTitle', 'Custom Title');
});
