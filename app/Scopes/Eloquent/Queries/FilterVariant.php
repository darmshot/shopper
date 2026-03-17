<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use App\Support\QueryFilter\HasProductCategories;
use Illuminate\Database\Eloquent\Builder;

readonly class FilterVariant extends EloquentQueryScope
{
    use HasProductCategories;

    /**
     * @param  array<string|int,mixed>  $filters
     */
    public function __construct(
        private array $filters,
    ) {}

    public function __invoke(Builder $query): void
    {
        $filters = $this->filters;

        $query->when(isset($filters['has_old_price']), function (Builder $query) {
            $query->whereNotNull('old_price');
        });

        $query->when($filters['name'] ?? null, function (Builder $query, mixed $value) {
            $query->where('name', $value);
        });

        $query->when($filters['product'] ?? null, function (Builder $query, mixed $value) {
            $query->whereHas('product',
                fn (Builder $query) => $value ? $query->tap(new FilterProduct((array) $value)) : $query);
        });
    }

    public static function byBrand(?string $value): FilterVariant
    {
        if (empty($value)) {
            return new self([]);
        }

        return new self([
            'product' => [
                'brand' => [
                    'id' => $value,
                ],
            ],
        ]);
    }
}
