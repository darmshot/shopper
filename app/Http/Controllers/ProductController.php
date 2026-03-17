<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Scopes\Eloquent\Queries\SortVariant;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        $product->load([
            'variants' => fn (HasMany $relation) => $relation->tap(new SortVariant),
            'variant',
            'brand',
        ]);

        return view('design.product', compact('product'));
    }
}
