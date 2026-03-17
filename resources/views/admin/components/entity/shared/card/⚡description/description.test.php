<?php

declare(strict_types=1);

use App\Models\Category;
use Livewire\Livewire;

it('renders successfully', function () {
    $category = new Category;

    Livewire::test('entity.shared.card.description', [
        'entity' => $category,
    ])->assertStatus(200);
});

it('loads description from category', function () {
    $category = Category::factory()->create([
        'description' => '<p>Category full description</p>',
    ]);

    Livewire::test('entity.shared.card.description', [
        'entity' => $category,
    ])->assertSet('description', '<p>Category full description</p>');
});
