<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use App\Models\Category;
use App\Support\QueryFilter\HasCategory;
use Illuminate\Database\Eloquent\Builder;

readonly class FilterFeature extends EloquentQueryScope
{
    use HasCategory;

    /**
     * @param  array<string|int,mixed>  $filters
     */
    public function __construct(
        private array $filters,
    ) {}

    public function __invoke(Builder $query): void
    {
        $filters = $this->filters;

        $query->when(isset($filters['in_filter']), static function (Builder $query) use ($filters) {
            $query->where('in_filter', $filters['in_filter']);
        });

        $query->when($filters['categories'] ?? null, static function (Builder $query, $value) {
            $query->whereHas('categories',
                fn (Builder $query) => $value ? $query->tap(new FilterCategory((array) $value)) : $query);
        });
    }

    public static function inFilter(): self
    {
        return new self([
            'in_filter' => true,
        ]);
    }

    public static function byCategory(?string $value): self
    {
        if (empty($value)) {
            return new self([]);
        }

        $childIds = Category::repository()->childIds($value);

        return new self([
            'categories' => [
                'id' => $childIds,
            ],
        ]);
    }
}
