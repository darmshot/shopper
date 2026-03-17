<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Option;

test('option constructor', function (array $rawAttributes, array $attributes) {
    $option = new Option($rawAttributes);

    expect($option->toArray())->toMatchArray($attributes);
})
    ->with('option raw attributes')
    ->with('option fillable attributes');
