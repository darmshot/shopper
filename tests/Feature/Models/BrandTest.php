<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Brand;

test('brand constructor', function (array $attributes) {
    $brand = new Brand([
        ...$attributes,
        'not_exists_field' => 'value',
    ]);

    expect($brand->toArray())->toMatchArray($attributes);
})->with('brand fillable attributes');
