<?php

declare(strict_types=1);

use App\Models\Feature;
use Livewire\Livewire;

it('renders successfully', function () {
    $feature = new Feature;

    Livewire::test('entity.feature.card.main-information', [
        'feature' => $feature,
    ])->assertStatus(200);
});

it('loads feature data into fields', function () {
    $feature = Feature::factory()->create([
        'name' => 'Test Feature',
    ]);

    Livewire::test('entity.feature.card.main-information', [
        'feature' => $feature,
    ])
        ->assertSet('name', 'Test Feature');
});
