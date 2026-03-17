<?php

declare(strict_types=1);

use App\Models\Feature;
use Livewire\Livewire;

it('renders successfully', function () {
    $feature = new Feature;

    Livewire::test('entity.feature.card.property-settings', [
        'feature' => $feature,
    ])->assertStatus(200);
});

it('loads in_filter value from feature', function () {
    $feature = Feature::factory()->create([
        'in_filter' => true,
    ]);

    Livewire::test('entity.feature.card.property-settings', [
        'feature' => $feature,
    ])->assertSet('inFilter', true);
});

it('defaults to false when feature has no in_filter value', function () {
    $feature = Feature::factory()->create([
        'in_filter' => false,
    ]);

    Livewire::test('entity.feature.card.property-settings', [
        'feature' => $feature,
    ])->assertSet('inFilter', false);
});
