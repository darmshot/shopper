<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Category;
use App\Services\Tree\Data\FlatCollection;
use App\Services\Tree\Data\Menu;
use App\Services\Tree\Data\Node;
use App\Services\Tree\Data\TreeCollection;

interface CategoryRepository
{
    /**
     * @return TreeCollection<Category>
     */
    public function tree(): TreeCollection;

    /**
     * @return FlatCollection<Category>
     */
    public function flatTree(): FlatCollection;

    /**
     * @return array<string, string>
     */
    public function childIds(string $category): array;

    /**
     * @return Node<Category>|null
     */
    public function category(string $category): ?Node;

    /**
     * @return TreeCollection<Category>
     */
    public function childrenWithSelf(string $category): TreeCollection;

    /**
     * @return TreeCollection<Category>
     */
    public function parentsWithSelf(string $category): TreeCollection;

    /**
     * @return Menu<Category>
     */
    public function menu(?string $category): Menu;
}
