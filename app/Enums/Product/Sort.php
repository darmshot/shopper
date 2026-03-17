<?php

declare(strict_types=1);

namespace App\Enums\Product;

enum Sort: string
{
    case CREATED_DESC = 'created_desc';
    case CREATED_ASC = 'created_asc';
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
    case NEW_ARRIVALS = 'new_arrivals';

    public static function tryCatalogMatch(string $value): ?self
    {
        return match ($value) {
            'new_desc' => Sort::CREATED_DESC,
            'new_asc' => Sort::CREATED_ASC,
            'price_asc' => Sort::PRICE_ASC,
            'price_desc' => Sort::PRICE_DESC,
            default => null,
        };
    }

    public function toCatalog(): string
    {
        return match ($this) {
            Sort::CREATED_DESC, Sort::NEW_ARRIVALS => 'new_desc',
            Sort::CREATED_ASC => 'new_asc',
            Sort::PRICE_ASC => 'price_asc',
            Sort::PRICE_DESC => 'price_desc',
        };
    }
}
