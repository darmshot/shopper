<?php

declare(strict_types=1);

dataset('variant raw attributes', [
    'variant_fillable_with_not_exists' => fn () => [
        'sku' => 'SKU-1',
        'name' => 'samsung 1',
        'price' => 100,
        'old_price' => 120,
        'stock' => null,
        'sort' => 1,
        'not_exists_field' => 'value',
    ],
]);

dataset('variant fillable attributes', [
    'variant_fillable_attributes' => fn () => [
        'sku' => 'SKU-1',
        'name' => 'samsung 1',
        'price' => 100,
        'old_price' => 120,
        'stock' => null,
        'sort' => 1,
    ],
]);
