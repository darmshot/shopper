<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Variant;

test('variant constructor', function (array $rawAttributes, array $attributes) {
    $variant = new Variant($rawAttributes);

    expect($variant->toArray())->toMatchArray($attributes);
})
    ->with('variant raw attributes')
    ->with('variant fillable attributes');
