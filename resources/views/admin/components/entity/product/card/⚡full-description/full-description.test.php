<?php

declare(strict_types=1);

use App\Models\Product;
use Livewire\Livewire;

it('renders successfully', function () {
    $product = new Product;

    Livewire::test('entity.product.card.full-description', [
        'product' => $product,
    ])->assertStatus(200);
});

it('loads description from product', function () {
    $product = Product::factory()->create([
        'description' => '<p>Full description text</p>',
    ]);

    Livewire::test('entity.product.card.full-description', [
        'product' => $product,
    ])->assertSet('description', '<p>Full description text</p>');
});
