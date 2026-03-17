<?php

declare(strict_types=1);

namespace App\Support\FormRequest\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;

trait HasStock
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function stockRules(string $key = 'stock'): array
    {
        return [
            $key => ['nullable', 'integer', 'min:0', 'max:4000000'],
        ];
    }
}
