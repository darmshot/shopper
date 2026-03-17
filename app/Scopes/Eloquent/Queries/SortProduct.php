<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use App\Enums\Product\Sort as SortEnum;
use Illuminate\Database\Eloquent\Builder;

readonly class SortProduct extends EloquentQueryScope
{
    public function __construct(
        private ?SortEnum $sort = SortEnum::CREATED_DESC,
    ) {}

    public function __invoke(Builder $query): void
    {
        match ($this->sort ?: SortEnum::CREATED_DESC) {
            SortEnum::CREATED_DESC, SortEnum::NEW_ARRIVALS => $query->latest(),
            SortEnum::CREATED_ASC => $query->oldest(),
            SortEnum::PRICE_ASC => $query
                ->withMin('variants', 'price')
                ->orderBy('variants_min_price'),
            SortEnum::PRICE_DESC => $query
                ->withMax('variants', 'price')
                ->orderBy('variants_max_price', 'desc'),
        };
    }
}
