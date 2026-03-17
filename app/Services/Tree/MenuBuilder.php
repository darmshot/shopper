<?php

declare(strict_types=1);

namespace App\Services\Tree;

use App\Services\Tree\Data\Menu;
use App\Services\Tree\Data\Nodeable;
use App\Services\Tree\Data\TreeCollection;

/**
 * @template TEntity of Nodeable
 */
readonly class MenuBuilder
{
    /**
     * @param  TreeCollection<TEntity>  $tree
     */
    public function __construct(
        private TreeCollection $tree,
    ) {}

    /**
     * @return Menu<TEntity>
     */
    public function menu(?string $id): Menu
    {
        $parents = $id ? $this->tree->parents($id)->collect() : collect();
        $siblings = $this->tree->siblings($id)->collect();
        $children = $this->tree->flatTree()->get($id)?->children->collect() ?? collect();

        $collection = collect([
            $parents,
            $siblings,
            $children,
        ])
            ->filter(fn ($item) => $item->isNotEmpty())
            ->take(-2);

        /** @var Menu<TEntity> */
        return new Menu(
            firstLevel: $collection->first() ?: collect(),
            secondLevel: $collection->skip(1)->first() ?: collect(),
        );
    }
}
