<?php

declare(strict_types=1);

dataset('option raw attributes', [
    'option_fillable_with_not_exists' => fn () => [
        'feature_id' => 24,
        'value' => 'Option 1',
        'not_exists_field' => 'value',
    ],
]);

dataset('option fillable attributes', [
    'option_fillable_attributes' => fn () => [
        'value' => 'Option 1',
    ],
]);
