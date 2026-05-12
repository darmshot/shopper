<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget;

use App\Enums\Product\Sort;
use App\Models\Product;
use App\Scopes\Eloquent\Queries\FilterProduct;
use App\Scopes\Eloquent\Queries\SortProduct;
use App\Support\Filters\FilterInput;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CatalogProducts extends Component
{
    /**
     * @var LengthAwarePaginator<int, Product>
     */
    public LengthAwarePaginator $products;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $categoryId = null,
        ?string $brandId = null,
        ?bool $discountOnly = false,
    ) {
        $variant = request()->string('variant')->toString();

        $features = request()->array('features') |> FilterInput::featureMap(...);

        $brands = request()->array('brands') |> FilterInput::stringList(...);

        $sort = request()->string('sort')->toString() |> Sort::tryCatalogMatch(...);

        $this->products = Product::query()
            ->with(['variant'])
            ->tap(FilterProduct::activeOnly()->asTap())
            ->tap(FilterProduct::byCategory($categoryId)->asTap())
            ->tap(FilterProduct::byVariant($variant)->asTap())
            ->tap(FilterProduct::byFeatures($features)->asTap())
            ->tap(FilterProduct::byBrands($brands)->asTap())
            ->tap(FilterProduct::byBrand($brandId)->asTap())
            ->tap(FilterProduct::discountOnly($discountOnly)->asTap())
            ->tap(new SortProduct($sort)->asTap())
            ->paginate(
                perPage: 18,
            )->withQueryString();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.catalog-products');
    }
}
