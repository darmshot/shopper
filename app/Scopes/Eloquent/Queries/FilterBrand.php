<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use App\Support\QueryFilter\HasProductsCategories;
use Illuminate\Database\Eloquent\Builder;

readonly class FilterBrand extends EloquentQueryScope
{
    use HasProductsCategories;

    /**
     * @param  array<string|int,mixed>  $filters
     */
    public function __construct(
        private array $filters,
    ) {}

    public function __invoke(Builder $query): void
    {
        $filters = $this->filters;

        $query->when($filters['id'] ?? null, function (Builder $query, $value) {
            $query->where('id', $value);
        });

        $query->when($filters['products'] ?? null, function (Builder $query, $value) {
            $query->whereHas('products', fn (Builder $query) => $value ? $query->tap(new FilterProduct((array) $value)) : $query);
        });
    }
}
