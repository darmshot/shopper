<?php

declare(strict_types=1);

use App\Models\Category;
use Livewire\Livewire;

it('renders successfully', function () {
    $category = new Category;

    Livewire::test('entity.category.card.main-information', [
        'category' => $category,
    ])->assertStatus(200);
});

it('loads category data into fields', function () {
    $parent = Category::factory()->create();
    $category = Category::factory()->create([
        'name' => 'Test Category',
        'active' => true,
        'parent_id' => $parent->id,
    ]);

    Livewire::test('entity.category.card.main-information', [
        'category' => $category,
    ])
        ->assertSet('name', 'Test Category')
        ->assertSet('active', true)
        ->assertSet('parentId', (string) $parent->id)
        ->assertSet('categoryId', $category->id);
});

it('loads null parentId when category has no parent', function () {
    $category = Category::factory()->create([
        'parent_id' => null,
    ]);

    Livewire::test('entity.category.card.main-information', [
        'category' => $category,
    ])
        ->assertSet('parentId', null);
});

it('dispatches name updated event when name changes', function () {
    $category = new Category;

    Livewire::test('entity.category.card.main-information', [
        'category' => $category,
    ])
        ->set('name', 'New Name')
        ->assertDispatched('entity.category.card.main-information.name.updated', name: 'New Name');
});

it('exposes category tree structure', function () {
    $root = Category::factory()->create(['name' => 'Root']);
    $child = Category::factory()->create([
        'name' => 'Child',
        'parent_id' => $root->id,
    ]);

    Livewire::test('entity.category.card.main-information', [
        'category' => new Category,
    ])
        ->assertSet('tree', function ($tree) use ($root, $child) {
            // tree() returns only root nodes
            return $tree->contains('entity.id', $root->id)
                   && ! $tree->contains('entity.id', $child->id);
        });
});
