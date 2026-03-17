<?php

declare(strict_types=1);

dataset('product fillable attributes', [
    'product_fillable_attributes' => fn () => [
        'url' => 'samsung',
        'name' => 'Samsung',
        'annotation' => 'check annotation',
        'description' => 'check description',
        'active' => true,
        'meta_title' => 'check meta title',
        'meta_description' => 'check meta description',
        'featured' => true,
    ],
]);
dataset('product raw attributes', [
    'product_fillable_with_not_exists' => fn () => [
        'url' => 'samsung',
        'name' => 'Samsung',
        'annotation' => 'check annotation',
        'description' => 'check description',
        'active' => true,
        'meta_title' => 'check meta title',
        'meta_description' => 'check meta description',
        'featured' => true,
        'not_exists_field' => 'value',
    ],
]);
