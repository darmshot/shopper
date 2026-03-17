<?php

declare(strict_types=1);

namespace App\Support\FormRequest\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;

trait HasPrice
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function priceRules(string $key = 'price'): array
    {
        return [
            $key => ['required', 'decimal:0,2', 'min:1', 'max:900000000'],
        ];
    }
}
