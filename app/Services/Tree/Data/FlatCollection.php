<?php

declare(strict_types=1);

namespace App\Services\Tree\Data;

use Illuminate\Support\Collection;
use Override;

/**
 * @template TEntity of Nodeable
 *
 * @extends Collection<string, Node<TEntity>>
 */
class FlatCollection extends Collection
{
    /**
     * @return TreeCollection<TEntity>
     */
    public function childrenWithSelf(string $id): TreeCollection
    {
        $node = $this->get($id);

        if (empty($node)) {
            /** @var TreeCollection<TEntity> */
            return new TreeCollection;
        }

        /** @var TreeCollection<TEntity> $collection */
        $collection = new TreeCollection([
            $node,
            ...$node->children,
        ]);

        return $collection;
    }

    /**
     * @return TreeCollection<TEntity>
     */
    public function parentsWithSelf(string $id): TreeCollection
    {
        $node = $this->get($id);

        if (empty($node)) {
            /** @var TreeCollection<TEntity> */
            return new TreeCollection;
        }

        /** @var TreeCollection<TEntity> $collection */
        $collection = new TreeCollection($node->parents);

        $collection->push($node);

        return $collection;
    }

    /**
     * @return array<string, string>
     */
    public function childIds(string $id): array
    {
        $category = $this->get($id);

        /** @var array<string, string> */
        return $category
            ?->childIds
            ->toArray() ?? [];
    }

    /**
     * @param  null  $default
     * @return Node<TEntity>|null
     */
    #[Override]
    public function get($key, $default = null): ?Node
    {
        return parent::get($key, $default);
    }

    /**
     * @param  null  $default
     * @return Node<TEntity>|null
     */
    #[Override]
    public function first(?callable $callback = null, $default = null): ?Node
    {
        return parent::first($callback, $default);
    }
}
