<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use App\Support\Eloquent\Scopes\Concerns\HasTapSupport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract readonly class EloquentQueryScope
{
    use HasTapSupport;

    /**
     * @param  Builder<Model>  $query
     */
    abstract public function __invoke(Builder $query): void;
}
