<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Feature;
use Livewire\Livewire;

it('renders successfully', function () {
    $feature = new Feature;

    Livewire::test('entity.feature.card.use-in-categories', [
        'feature' => $feature,
    ])->assertStatus(200);
});

it('loads selected categories from feature', function () {
    $categories = Category::factory()->count(3)->create();

    $feature = Feature::factory()->create();
    $feature->syncCategories($categories->pluck('id')->toArray());

    Livewire::test('entity.feature.card.use-in-categories', [
        'feature' => $feature,
    ])
        ->assertSet('categories', $categories->pluck('id')->toArray());
});

it('loads empty categories when feature has none', function () {
    $feature = Feature::factory()->create();

    Livewire::test('entity.feature.card.use-in-categories', [
        'feature' => $feature,
    ])
        ->assertSet('categories', []);
});

it('exposes categoryOptions from flatTree', function () {
    $root = Category::factory()->create(['name' => 'Root']);
    $child = Category::factory()->create([
        'name' => 'Child',
        'parent_id' => $root->id,
    ]);

    Livewire::test('entity.feature.card.use-in-categories', [
        'feature' => new Feature,
    ])
        ->assertSet('categoryOptions', function ($options) use ($root, $child) {
            return $options->contains('entity.id', $root->id)
                   && $options->contains('entity.id', $child->id);
        });
});
