<?php

declare(strict_types=1);

use App\Models\Product;
use Livewire\Livewire;

it('renders successfully', function () {
    $product = new Product;

    Livewire::test('entity.product.card.short-description', [
        'product' => $product,
    ])->assertStatus(200);
});

it('loads annotation from product', function () {
    $product = Product::factory()->create([
        'annotation' => 'Short description text',
    ]);

    Livewire::test('entity.product.card.short-description', [
        'product' => $product,
    ])->assertSet('annotation', 'Short description text');
});
