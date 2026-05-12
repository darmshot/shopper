<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget;

use App\Models\Product;
use App\Scopes\Eloquent\Queries\FilterProduct;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

class RelatedProducts extends Component
{
    /**
     * @var Collection<int, Product>
     */
    public Collection $products;

    /**
     * Create a new component instance.
     */
    public function __construct(string $productId)
    {
        $this->products = Product::query()
            ->with(['variant'])
            ->tap(FilterProduct::activeOnly()->asTap())
            ->tap(FilterProduct::byRelated($productId)->asTap())
            ->limit(10)
            ->get();
    }

    #[Override]
    public function shouldRender(): bool
    {
        return $this->products->isNotEmpty();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.related-products');
    }
}
