<?php

declare(strict_types=1);

namespace App\Repositories\ObjectCache;

use App\Models\Category;
use App\Scopes\Eloquent\Transforms\TreeCategory;
use App\Services\Tree\Data\FlatCollection;
use App\Services\Tree\Data\Menu;
use App\Services\Tree\Data\Node;
use App\Services\Tree\Data\TreeCollection;
use App\Services\Tree\MenuBuilder;

class CategoryRepository implements \App\Contracts\Repositories\CategoryRepository
{
    public function __construct() {}

    public function tree(): TreeCollection
    {
        /** @var TreeCollection<Category> $categories */
        $categories = Category::query()
            ->pipe(new TreeCategory);

        return $categories;
    }

    /**
     * @return FlatCollection<Category>
     */
    public function flatTree(): FlatCollection
    {
        return $this->tree()->flatTree();
    }

    public function childIds(string $category): array
    {
        return $this->flatTree()->childIds($category);
    }

    public function category(string $category): ?Node
    {
        return $this->flatTree()->get($category);
    }

    /**
     * @return TreeCollection<Category>
     */
    public function childrenWithSelf(string $category): TreeCollection
    {
        return $this->flatTree()->childrenWithSelf($category);
    }

    public function parentsWithSelf(string $category): TreeCollection
    {
        return $this->flatTree()->parentsWithSelf($category);
    }

    public function menu(?string $category): Menu
    {
        return new MenuBuilder($this->tree())->menu($category);
    }
}
