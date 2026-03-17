<?php

declare(strict_types=1);

use App\Models\Product;
use Livewire\Livewire;

it('renders successfully', function () {
    $product = new Product;

    Livewire::test('entity.product.card.relation-products', [
        'product' => $product,
    ])->assertStatus(200);
});

it('loads existing related products', function () {
    $relatedA = Product::factory()->create();
    $relatedB = Product::factory()->create();

    $product = Product::factory()
        ->hasAttached($relatedA, ['sort' => 1], 'related')
        ->hasAttached($relatedB, ['sort' => 2], 'related')
        ->create();

    Livewire::test('entity.product.card.relation-products', [
        'product' => $product,
    ])
        ->assertSet('related', [$relatedA->id, $relatedB->id])
        ->assertSee($relatedA->name)
        ->assertSee($relatedB->name);
});

it('returns correct relatedCollection', function () {
    $related = Product::factory()->create([
        'name' => 'Related Product',
    ]);

    $product = Product::factory()
        ->hasAttached($related, ['sort' => 1], 'related')
        ->create();

    Livewire::test('entity.product.card.relation-products', [
        'product' => $product,
    ])
        ->assertSee('Related Product')
        ->assertSet('relatedCollection.'.$related->id.'.id', $related->id);
});

it('searches for related products', function () {
    $match = Product::factory()->create(['name' => 'Super Phone']);
    $other = Product::factory()->create(['name' => 'Laptop']);

    Livewire::test('entity.product.card.relation-products', [
        'product' => new Product,
    ])
        ->set('searchRelated', 'Su')
        ->assertSet('suggestRelated.0.id', $match->id)
        ->assertDontSee($other->name);
});

it('clears suggestions when search query is too short', function () {
    Livewire::test('entity.product.card.relation-products', [
        'product' => new Product,
    ])
        ->set('searchRelated', 'S')
        ->assertSet('suggestRelated', []);
});

it('adds a related product and clears search state', function () {
    $related = Product::factory()->create();

    Livewire::test('entity.product.card.relation-products', [
        'product' => new Product,
    ])
        ->set('searchRelated', 'Phone')
        ->set('suggestRelated', [
            ['id' => $related->id, 'name' => $related->name, 'images' => []],
        ])
        ->call('addRelated', $related->id)
        ->assertSet('related', [$related->id])
        ->assertSet('searchRelated', '')
        ->assertSet('suggestRelated', []);
});

it('does not add duplicate related products', function () {
    $related = Product::factory()->create();

    Livewire::test('entity.product.card.relation-products', [
        'product' => new Product,
    ])
        ->set('related', [$related->id])
        ->call('addRelated', $related->id)
        ->assertSet('related', [$related->id]); // unchanged
});

it('removes a related product', function () {
    $a = Product::factory()->create();
    $b = Product::factory()->create();

    Livewire::test('entity.product.card.relation-products', [
        'product' => new Product,
    ])
        ->set('related', [$a->id, $b->id])
        ->call('removeRelated', $a->id)
        ->assertSet('related', [1 => $b->id]);
});

it('reorders related products', function () {
    $a = Product::factory()->create();
    $b = Product::factory()->create();
    $c = Product::factory()->create();

    Livewire::test('entity.product.card.relation-products', [
        'product' => new Product,
    ])
        ->set('related', [$a->id, $b->id, $c->id])
        ->call('reorderRelated', [$c->id, $a->id, $b->id])
        ->assertSet('related', [$c->id, $a->id, $b->id]);
});
