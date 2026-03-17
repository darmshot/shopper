<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use App\Support\QueryFilter\HasProductCategories;
use Illuminate\Database\Eloquent\Builder;

readonly class FilterOption extends EloquentQueryScope
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

        $query->when($filters['feature_id'] ?? null, static function (Builder $query, $value) {
            $query->whereIn('feature_id', (array) $value);
        });

        $query->when($filters['value'] ?? null, static function (Builder $query, $value) {
            $query->whereIn('value', (array) $value);
        });

        $query->when($filters['feature_with_values'] ?? null, static function (Builder $query, $value) {
            /** @var array<int,array{feature_id:string,values:array<int,string>}> $value */
            foreach ($value as $item) {
                $query->where(static fn (Builder $query) => $query
                    ->where('feature_id', $item['feature_id'])
                    ->whereIn('value', $item['values']));
            }
        });

        $query->when($filters['product'] ?? null, static function (Builder $query, $value) {
            $query->whereHas('product',
                fn (Builder $query) => $value ? $query->tap(new FilterProduct((array) $value)) : $query);
        });
    }
}
