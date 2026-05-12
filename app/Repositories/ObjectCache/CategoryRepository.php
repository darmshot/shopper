<?php

declare(strict_types=1);

namespace App\Repositories\ObjectCache;

use App\Models\Category;
use App\Services\Tree\Data\FlatCollection;
use App\Services\Tree\Data\Menu;
use App\Services\Tree\Data\Node;
use App\Services\Tree\Data\TreeCollection;

/**
 * @template TKey of string
 * @template TValue of mixed
 */
class CategoryRepository implements \App\Contracts\Repositories\CategoryRepository
{
    /**
     * @var array<string, mixed>
     */
    private array $cache = [];

    public function __construct(
        private readonly \App\Contracts\Repositories\CategoryRepository $next,
    ) {}

    public function tree(): TreeCollection
    {
        /** @var TreeCollection<Category> */
        return $this->remember('tree', fn () => $this->next->tree());
    }

    public function flatTree(): FlatCollection
    {
        /** @var FlatCollection<Category> */
        return $this->remember('flatTree', fn () => $this->next->flatTree());
    }

    /**
     * @return array<string,string>
     */
    public function childIds(string $category): array
    {
        /** @var array<string,string> */
        return $this->remember("childIds:$category", fn () => $this->next->childIds($category));
    }

    public function category(string $category): ?Node
    {
        /** @var Node<Category>|null */
        return $this->remember("category:$category", fn () => $this->next->category($category));
    }

    public function childrenWithSelf(string $category): TreeCollection
    {
        /** @var TreeCollection<Category> */
        return $this->remember("childrenWithSelf:$category", fn () => $this->next->childrenWithSelf($category));
    }

    public function parentsWithSelf(string $category): TreeCollection
    {
        /** @var TreeCollection<Category> */
        return $this->remember("parentsWithSelf:$category", fn () => $this->next->parentsWithSelf($category));
    }

    public function menu(?string $category): Menu
    {
        $key = 'menu:'.($category ?? 'root');

        /** @var Menu<Category> */
        return $this->remember($key, fn () => $this->next->menu($category));
    }

    /**
     * @template T
     *
     * @param  callable():T  $callback
     * @return T
     */
    private function remember(string $key, callable $callback): mixed
    {
        /** @var T */
        return $this->cache[$key] ??= $callback();
    }
}
