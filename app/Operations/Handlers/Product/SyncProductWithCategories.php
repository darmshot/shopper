<?php

declare(strict_types=1);

namespace App\Operations\Handlers\Product;

use App\Models\Category;
use Illuminate\Support\Collection;

class SyncProductWithCategories
{
    /**
     * @param  array<string, int>  $order
     * @param  Collection<int, Category>  $assignedCategories
     * @param  Collection<int, Category>  $assigningCategories
     */
    public function __invoke(
        string $productId,
        Collection $assignedCategories,
        Collection $assigningCategories,
        array $order,
    ): void {
        $assignedCategoryIds = $assignedCategories
            ->pluck('id')
            ->toArray();

        $assigningCategoriesIds = $assigningCategories
            ->pluck('id')
            ->toArray();

        foreach ($assignedCategories as $category) {
            if (in_array($category->id, $assigningCategoriesIds)) {
                continue;
            }

            $category->detachProduct($productId);
        }

        foreach ($assigningCategories as $category) {
            if (in_array($category->id, $assignedCategoryIds)) {
                continue;
            }

            $sort = $order[$category->id] ?? 0;

            $category->attachProduct($productId, ['sort' => $sort]);
        }
    }
}
