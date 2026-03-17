<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget;

use App\Enums\Product\Sort;
use App\Models\Product;
use App\Scopes\Eloquent\Queries\SortProduct;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

class NewArrivalsProducts extends Component
{
    /** @var Collection<int,Product> */
    public Collection $products;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->products = Product::query()
            ->with(['variant'])
            ->tap(new SortProduct(Sort::NEW_ARRIVALS)->asTap())
            ->limit(18)
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
        return view('design.components.widget.new-arrivals-products');
    }
}
