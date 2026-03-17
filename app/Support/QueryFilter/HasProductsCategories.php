<?php

declare(strict_types=1);

namespace App\Support\QueryFilter;

use App\Models\Category;

trait HasProductsCategories
{
    public static function byCategory(?string $value): self
    {
        if (empty($value)) {
            return new self([]);
        }

        $childIds = Category::repository()->childIds($value);

        return new self([
            'products' => [
                'categories' => [
                    'id' => $childIds,
                ],
            ],
        ]);
    }
}
