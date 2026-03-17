<?php

declare(strict_types=1);

namespace App\Services\Tree\Data;

use Illuminate\Support\Collection;

/**
 * @template TEntity of Nodeable
 */
class Node
{
    /**
     * @param  TEntity  $entity
     * @param  TreeCollection<TEntity>  $children
     * @param  TreeCollection<TEntity>  $parents
     * @param  Collection<string, string>  $childIds
     * @param  Collection<int, string>  $parentIds
     */
    public function __construct(
        public object $entity,
        public TreeCollection $children,
        public TreeCollection $parents,
        public Collection $childIds,
        public Collection $parentIds,
        public int $level,
        public int $productsTotal,
    ) {}
}
