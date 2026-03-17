<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Product;

test('product constructor', function (array $rawAttributes, array $attributes) {
    $product = new Product($rawAttributes);

    expect($product->toArray())->toMatchArray($attributes);
})
    ->with('product raw attributes')
    ->with('product fillable attributes');
