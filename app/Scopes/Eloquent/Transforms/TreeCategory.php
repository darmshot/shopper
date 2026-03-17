<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Transforms;

use App\Models\Category;
use App\Services\Tree\Data\TreeCollection;
use App\Services\Tree\TreeBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @extends EloquentTransformScope<Category>
 */
readonly class TreeCategory extends EloquentTransformScope
{
    /**
     * @param  Builder<Category>  $query
     * @return TreeCollection<Category>
     */
    public function __invoke(Builder $query): TreeCollection
    {
        /** @var Collection<int, Category> $categories */
        $categories = $query
            ->orderBy('sort')
            ->orderBy('name')
            ->withCount(['products', 'children'])
            ->get();

        /** @var TreeBuilder<Category> $builder */
        $builder = new TreeBuilder($categories);

        return $builder->nodeCollection();
    }
}
