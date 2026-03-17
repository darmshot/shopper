<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Feature;

test('feature constructor', function (array $rawAttributes, array $attributes) {
    $feature = new Feature($rawAttributes);

    expect($feature->toArray())->toMatchArray($attributes);
})
    ->with('feature raw attributes')
    ->with('feature fillable attributes');
