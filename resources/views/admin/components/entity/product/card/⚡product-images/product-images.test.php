<?php

declare(strict_types=1);

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('renders successfully', function () {
    $product = new Product;

    Livewire::test('entity.product.card.product-images', [
        'product' => $product,
    ])->assertStatus(200);
});

it('loads only existing images from storage', function () {
    Storage::fake('public');

    // Create fake files
    Storage::put('products/img1.jpg', 'fake');
    Storage::put('products/img2.webp', 'fake');

    // One missing file
    $product = Product::factory()->create([
        'images' => [
            'products/img1.jpg',
            'products/img2.webp',
            'products/missing.jpg', // does not exist
        ],
    ]);

    Livewire::test('entity.product.card.product-images', [
        'product' => $product,
    ])
        ->assertSet('images.0.name', 'img1.jpg')
        ->assertSet('images.1.name', 'img2.webp')
        ->assertSet('images', function ($images) {
            return count($images) === 2; // missing file filtered out
        });
});

it('maps image paths to correct structure', function () {
    Storage::fake('public');

    Storage::put('products/photo.jpg', 'fake');

    $product = Product::factory()->create([
        'images' => ['products/photo.jpg'],
    ]);

    Livewire::test('entity.product.card.product-images', [
        'product' => $product,
    ])
        ->assertSet('images.0.name', 'photo.jpg')
        ->assertSet('images.0.path', 'products/photo.jpg')
        ->assertSet('images.0.url', Storage::url('products/photo.jpg'))
        ->assertSet('images.0.size', Storage::size('products/photo.jpg'));
});

it('exposes correct dropzone configuration', function () {
    $product = new Product;

    Livewire::test('entity.product.card.product-images', [
        'product' => $product,
    ])
        ->assertSet('dropzoneConfig.maxFilesize', 2)
        ->assertSet('dropzoneConfig.acceptedFiles', '.jpg,.jpeg,.webp');
});
