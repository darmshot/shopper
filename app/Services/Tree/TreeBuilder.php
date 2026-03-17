<?php

declare(strict_types=1);

namespace App\Services\Tree;

use App\Services\Tree\Data\Node;
use App\Services\Tree\Data\Nodeable;
use App\Services\Tree\Data\TreeCollection;
use Illuminate\Support\Collection;

/**
 * @template TEntity of Nodeable
 */
readonly class TreeBuilder
{
    /**
     * @param  Collection<int, TEntity>  $items
     */
    public function __construct(
        private Collection $items,
    ) {}

    /**
     * @return TreeCollection<TEntity>
     */
    public function nodeCollection(): TreeCollection
    {
        /** @var Collection<string, TEntity> $categories */
        $categories = $this->items->keyBy('id');

        /** @var Collection<string, Node<TEntity>> $nodes */
        $nodes = collect();

        /** @var Nodeable $category */
        foreach ($categories as $category) {
            /** @var TreeCollection<TEntity> $children */
            $children = new TreeCollection;
            /** @var TreeCollection<TEntity> $parents */
            $parents = new TreeCollection;
            /** @var Collection<int,string> $parentIds */
            $parentIds = new Collection;
            $nodes->put($category->getId(), new Node(
                entity: $category,
                children: $children,
                parents: $parents,
                childIds: collect([$category->getId() => $category->getId()]),
                parentIds: $parentIds,
                level: 0,
                productsTotal: 0,
            ));
        }

        /** @var TreeCollection<TEntity> $roots */
        $roots = new TreeCollection;
        foreach ($nodes as $node) {
            // Attach to parent OR mark as root
            if ($node->entity->getParentId() && isset($nodes[$node->entity->getParentId()])) {
                $nodes[$node->entity->getParentId()]->children->push($node);
            } else {
                $roots->push($node);
            }
        }

        // BFS: compute levels, parents, parentIds, childIds
        $queue = [];

        foreach ($roots as $root) {
            $root->level = 0;
            $queue[] = $root;
        }

        while ($queue) {
            /** @var Node<TEntity> $node */
            $node = array_shift($queue);

            foreach ($node->children as $child) {
                $child->level = $node->level + 1;

                /** @phpstan-ignore-next-line  */
                $child->parents = $node->parents->concat([$node]);
                /** @phpstan-ignore-next-line  */
                $child->parentIds = $child->parents->map->entity->pluck('id')->values();

                $queue[] = $child;
            }
        }

        // Bottom‑up: compute productsTotal
        foreach ($nodes->sortByDesc('level') as $node) {
            /** @var Node<TEntity> $node */
            $total = $node->entity->getProductsCount() ?: 0;

            foreach ($node->children as $child) {
                /** @var Node<TEntity> $child */
                $total += $child->productsTotal;

                $node->childIds = $node->childIds->merge($child->childIds);
            }

            $node->productsTotal = $total;
        }

        return $roots;
    }
}
