<?php

declare(strict_types=1);

dataset('feature raw attributes', [
    'feature_fillable_with_not_exists' => fn () => [
        'name' => 'Тип',
        'sort' => 0,
        'in_filter' => true,
        'not_exists_field' => 'value',
    ],
]);

dataset('feature fillable attributes', [
    'feature_fillable_attributes' => fn () => [
        'name' => 'Тип',
        'sort' => 0,
        'in_filter' => true,
    ],
]);
