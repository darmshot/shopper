<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use Illuminate\Database\Eloquent\Builder;

readonly class FilterCategory extends EloquentQueryScope
{
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
            $query->whereIn('id', (array) $value);
        });

        $query->when($filters['products'] ?? null, function (Builder $query, $value) {
            $query->whereHas('products', fn (Builder $query) => $value ? $query->tap(new FilterProduct((array) $value)) : $query);
        });
    }

    public static function byProduct(?string $value): self
    {
        if (empty($value)) {
            return new self([]);
        }

        return new self([
            'products' => [
                'id' => $value,
            ],
        ]);
    }
}
