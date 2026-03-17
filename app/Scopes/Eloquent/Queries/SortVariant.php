<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use Illuminate\Database\Eloquent\Builder;

/**
 * Order by sort asc
 */
readonly class SortVariant extends EloquentQueryScope
{
    public function __invoke(Builder $query): void
    {
        $query->orderBy('sort');
    }
}
