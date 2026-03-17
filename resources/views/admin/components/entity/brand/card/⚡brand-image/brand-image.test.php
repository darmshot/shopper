<?php

declare(strict_types=1);

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('renders successfully', function () {
    $brand = new Brand;

    Livewire::test('entity.brand.card.brand-image', [
        'brand' => $brand,
    ])->assertStatus(200);
});

it('loads existing image from storage', function () {
    Storage::fake('public');

    Storage::put('brands/cat.jpg', 'fake');

    $brand = Brand::factory()->create([
        'image' => 'brands/cat.jpg',
    ]);

    Livewire::test('entity.brand.card.brand-image', [
        'brand' => $brand,
    ])
        ->assertSet('images.0.name', 'cat.jpg')
        ->assertSet('images.0.path', 'brands/cat.jpg')
        ->assertSet('images.0.url', Storage::url('brands/cat.jpg'))
        ->assertSet('images.0.size', Storage::size('brands/cat.jpg'));
});

it('ignores missing image file', function () {
    Storage::fake('public');

    $brand = Brand::factory()->create([
        'image' => 'brands/missing.jpg',
    ]);

    Livewire::test('entity.brand.card.brand-image', [
        'brand' => $brand,
    ])
        ->assertSet('images', null);
});

it('exposes correct dropzone configuration', function () {
    $brand = new Brand;

    Livewire::test('entity.brand.card.brand-image', [
        'brand' => $brand,
    ])
        ->assertSet('dropzoneConfig.maxFilesize', 2)
        ->assertSet('dropzoneConfig.acceptedFiles', '.jpg,.jpeg,.webp');
});
