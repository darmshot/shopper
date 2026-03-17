<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget;

use App\Models\Brand;
use App\Scopes\Eloquent\Transforms\AlphabetBrand;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

/**
 * @phpstan-type AlphabetItem object{symbol: string, items: Collection<int, Brand>}
 */
class CatalogBrands extends Component
{
    /**
     * @var LengthAwarePaginator<int, AlphabetItem>
     */
    public LengthAwarePaginator $groups;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        /**
         * @var LengthAwarePaginator<int, AlphabetItem> $paginate */
        $paginate = Brand::query()
            ->has('products')
            ->pipe(new AlphabetBrand(
                perPage: 10,
            ));

        $this->groups = $paginate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.catalog-brands');
    }
}
