<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Transforms;

use App\Models\Brand;
use App\Scopes\Eloquent\Queries\SortBrand;
use App\Services\Paginate\AlphabetPaginateBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @extends EloquentTransformScope<Brand>
 */
readonly class AlphabetBrand extends EloquentTransformScope
{
    public function __construct(
        private ?int $perPage = null,
    ) {}

    /**
     * Invoke alphabetical pagination.
     *
     * @param  Builder<Brand>  $query
     * @return LengthAwarePaginator<int, object{symbol: string, items: Collection<int, Brand>}>
     */
    public function __invoke(Builder $query): LengthAwarePaginator
    {
        $query->tap(new SortBrand()->asTap());

        $paginated = $query->paginate(perPage: $this->perPage);

        return new AlphabetPaginateBuilder($paginated)->build();
    }
}
