<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Category;

test('category constructor', function (array $attributes) {
    $category = new Category([
        ...$attributes,
        'not_exists_field' => 'value',
    ]);

    expect($category->toArray())->toMatchArray($attributes);
})->with('category fillable attributes');
