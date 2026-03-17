<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Transforms;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
abstract readonly class EloquentTransformScope
{
    /**
     * @param  Builder<TModel>  $query
     */
    abstract public function __invoke(Builder $query): mixed;
}
