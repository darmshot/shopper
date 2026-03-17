<?php

declare(strict_types=1);

namespace App\Services\Tree\Data;

use Illuminate\Support\Collection;
use Override;

/**
 * @template  TEntity of Nodeable
 *
 * @extends Collection<int, Node<TEntity>>
 */
class TreeCollection extends Collection
{
    /**
     * @return FlatCollection<TEntity>
     */
    public function flatTree(): FlatCollection
    {
        $flat = new Collection;

        $walker = static function (TreeCollection $nodes) use (&$walker, $flat) {
            foreach ($nodes as $node) {
                $flat->push($node);

                if ($node->children->isNotEmpty()) {
                    $walker($node->children);
                }
            }
        };

        $walker($this);

        /** @var Collection<string, Node<TEntity>> $items */
        $items = $flat->keyBy('entity.id');

        /** @var FlatCollection<TEntity> */
        return new FlatCollection($items->items);
    }

    /**
     * @return TreeCollection<TEntity>
     */
    public function limitDepth(int $maxLevel): self
    {
        /**
         * @param  TreeCollection<TEntity>  $nodes
         * @return TreeCollection<TEntity>
         */
        $walker = function (TreeCollection $nodes) use (&$walker, $maxLevel) {
            /** @var TreeCollection<TEntity> $result */
            $result = new TreeCollection;

            foreach ($nodes as $node) {
                $clone = clone $node;

                $clone->children = $node->level < $maxLevel
                    ? $walker($node->children)
                    : new TreeCollection;

                $result->push($clone);
            }

            return $result;
        };

        return $walker($this);
    }

    /**
     * @return self<TEntity>
     */
    public function searchTree(?string $value): self
    {
        if (empty($value)) {
            return $this;
        }

        $value = mb_strtolower(trim($value));

        /**
         * @param  TreeCollection<TEntity>  $nodes
         * @return TreeCollection<TEntity>
         */
        $walker = function (TreeCollection $nodes) use (&$walker, $value) {
            /** @var TreeCollection<TEntity> $result */
            $result = new TreeCollection;

            foreach ($nodes as $node) {
                $match = $node->entity->getName()
                         |> mb_strtolower(...)
                         |> (fn ($x) => str_contains($x, $value));

                $children = $walker($node->children);

                if ($match || $children->isNotEmpty()) {
                    $clone = clone $node;
                    $clone->children = $children;
                    $result->push($clone);
                }
            }

            return $result;
        };

        return $walker($this);
    }

    /**
     * @return $this|self<TEntity>
     */
    public function parents(string $id): self
    {
        $flatTree = $this->flatTree();

        $node = $id ? $flatTree->get($id) : null;

        /** @var self<TEntity> $collection */
        $collection = new self;

        if (empty($node)) {
            return $collection;
        }

        $parent = $node->entity->getParentId() ? $flatTree->get($node->entity->getParentId()) : null;

        if (empty($parent)) {
            return $collection;
        }

        if (empty($parent->entity->getParentId())) {
            return $this;
        }

        $node = $flatTree->get($parent->entity->getParentId());

        if (empty($node)) {
            /** @var self<TEntity> */
            return new self;
        }

        return $node->children;
    }

    /**
     * @return $this|self<TEntity>
     */
    public function siblings(?string $id): self
    {
        $flatTree = $this->flatTree();

        $node = $id ? $flatTree->get($id) : null;

        if (empty($node)) {
            return $this;
        }

        if (empty($node->entity->getParentId())) {
            return $this;
        }

        $parent = $flatTree->get($node->entity->getParentId());

        if (empty($parent)) {
            /** @var self<TEntity> */
            return new self;
        }

        return $parent->children;
    }

    /**
     * @param  int  $key
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
