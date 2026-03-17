<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget\ProductToolbar;

use App\Models\Brand;
use App\Scopes\Eloquent\Queries\FilterBrand as BrandFilterScope;
use App\Scopes\Eloquent\Queries\SortBrand;
use App\Support\Filters\FilterInput;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

class BrandFilter extends Component
{
    /**
     * @var Collection<int,Brand>
     */
    public Collection $brands;

    /**
     * @var array<int,string>
     */
    public array $brandsInput;

    public bool $active;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $categoryId)
    {
        $this->brandsInput = request()->array('brands') |> FilterInput::stringList(...);

        $this->active = ! empty($this->brandsInput);

        $this->brands = Brand::query()
            ->tap(BrandFilterScope::byCategory($categoryId)->asTap())
            ->tap(new SortBrand()->asTap())
            ->get();
    }

    #[Override]
    public function shouldRender(): bool
    {
        return $this->brands->isNotEmpty();
    }

    public function checked(string $brandId): bool
    {
        return in_array($brandId, $this->brandsInput);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.product-toolbar.brand-filter');
    }
}
