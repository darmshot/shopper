<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use Illuminate\Database\Eloquent\Builder;

/**
 * Sort by latest
 */
readonly class SortFeature extends EloquentQueryScope
{
    public function __invoke(Builder $query): void
    {
        $query->latest();
    }
}
