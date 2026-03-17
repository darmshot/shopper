<?php

declare(strict_types=1);

use App\Models\Brand;
use Livewire\Livewire;

it('renders successfully', function () {
    $brand = new Brand;

    Livewire::test('entity.brand.card.main-information', [
        'brand' => $brand,
    ])->assertStatus(200);
});

it('loads brand data into fields', function () {
    $brand = Brand::factory()->create([
        'name' => 'Test Brand',
    ]);

    Livewire::test('entity.brand.card.main-information', [
        'brand' => $brand,
    ])
        ->assertSet('name', 'Test Brand');
});

it('dispatches name updated event when name changes', function () {
    $brand = new Brand;

    Livewire::test('entity.brand.card.main-information', [
        'brand' => $brand,
    ])->set('name', 'New Name')
        ->assertDispatched('entity.brand.card.main-information.name.updated', name: 'New Name');
});
