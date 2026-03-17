<?php

declare(strict_types=1);

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('renders successfully', function () {
    $category = new Category;

    Livewire::test('entity.shared.card.image', [
        'entity' => $category,
    ])->assertStatus(200);
});

it('loads existing image from storage', function () {
    Storage::fake('public');

    Storage::put('categories/cat.jpg', 'fake');

    $category = Category::factory()->create([
        'image' => 'categories/cat.jpg',
    ]);

    Livewire::test('entity.shared.card.image', [
        'entity' => $category,
    ])
        ->assertSet('images.0.name', 'cat.jpg')
        ->assertSet('images.0.path', 'categories/cat.jpg')
        ->assertSet('images.0.url', Storage::url('categories/cat.jpg'))
        ->assertSet('images.0.size', Storage::size('categories/cat.jpg'));
});

it('ignores missing image file', function () {
    Storage::fake('public');

    $category = Category::factory()->create([
        'image' => 'categories/missing.jpg',
    ]);

    Livewire::test('entity.shared.card.image', [
        'entity' => $category,
    ])
        ->assertSet('images', null);
});

it('exposes correct dropzone configuration', function () {
    $category = new Category;

    Livewire::test('entity.shared.card.image', [
        'entity' => $category,
    ])
        ->assertSet('dropzoneConfig.maxFilesize', 2)
        ->assertSet('dropzoneConfig.acceptedFiles', '.jpg,.jpeg,.webp');
});
