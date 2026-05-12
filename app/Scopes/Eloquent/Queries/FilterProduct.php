<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use App\Support\QueryFilter\HasCategory;
use Illuminate\Database\Eloquent\Builder;

readonly class FilterProduct extends EloquentQueryScope
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

        $query->when($filters['id'] ?? null, static function (Builder $query, $value) {
            $query->whereIn('id', (array) $value);
        });

        $query->when(isset($filters['active']), static function (Builder $query) use ($filters) {
            $query->where('active', $filters['active']);
        });

        $query->when(isset($filters['featured']), static function (Builder $query) use ($filters) {
            $query->where('featured', $filters['featured']);
        });

        $query->when($filters['variants'] ?? null, static function (Builder $query, $value) {
            $query->whereHas('variants',
                fn (Builder $query) => $value ? $query->tap(new FilterVariant((array) $value)) : $query);
        });

        $query->when($filters['categories'] ?? null, static function (Builder $query, $value) {
            $query->whereHas('categories',
                fn (Builder $query) => $value ? $query->tap(new FilterCategory((array) $value)) : $query);
        });

        $query->when($filters['brand'] ?? null, static function (Builder $query, $value) {
            $query->whereHas('brand',
                fn (Builder $query) => $value ? $query->tap(new FilterBrand((array) $value)) : $query);
        });

        $query->when($filters['options'] ?? null, static function (Builder $query, $value) {
            $query->whereHas('options',
                fn (Builder $query) => $value ? $query->tap(new FilterOption((array) $value)) : $query);
        });

        $query->when($filters['related'] ?? null, static function (Builder $query, $value) {
            $query->whereHas('related', fn (Builder $query) => $value ? $query->tap(new self((array) $value)) : $query);
        });
    }

    /**
     * @param  array<int, string>  $values
     */
    public static function byBrands(array $values): self
    {
        if (empty($values)) {
            return new self([]);
        }

        return new self([
            'brand' => [
                'id' => $values,
            ],
        ]);
    }

    public static function byBrand(?string $value): self
    {
        if (empty($value)) {
            return new self([]);
        }

        return new self([
            'brand' => [
                'id' => $value,
            ],
        ]);
    }

    /**
     * @param  array<string, array<int, string>>  $features
     */
    public static function byFeatures(array $features): self
    {
        $featureWithValues = [];

        foreach ($features as $featureId => $values) {
            $featureWithValues[] = [
                'feature_id' => $featureId,
                'values' => $values,
            ];
        }

        if (empty($featureWithValues)) {
            return new self([]);
        }

        return new self([
            'options' => [
                'feature_with_values' => $featureWithValues,
            ],
        ]);
    }

    public static function byVariant(?string $value): self
    {
        return new self([
            'variants' => [
                'name' => $value,
            ],
        ]);
    }

    public static function discountOnly(?bool $value = true): self
    {
        if (empty($value)) {
            return new self([]);
        }

        return new self([
            'variants' => [
                'has_old_price' => $value,
            ],
        ]);
    }

    public static function byFilter(?string $value): self
    {
        return new self(match ($value) {
            'feature' => [
                'featured' => true,
            ],
            'discounted' => [
                'variants' => ['has_old_price' => true],
            ],
            'active' => [
                'active' => true,
            ],
            'inactive' => [
                'active' => false,
            ],
            'out_of_stock' => [
                'variants' => [
                    'stock' => 0,
                ],
            ],
            default => []
        });
    }

    public static function byRelated(?string $productId): self
    {
        return new self([
            'related' => ['id' => $productId],
        ]);
    }

    public static function activeOnly(): self
    {
        return new self([
            'active' => true,
            'variants' => [],
        ]);
    }
}
