<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget\ProductToolbar;

use App\Models\Variant;
use App\Scopes\Eloquent\Queries\FilterVariant as VariantFilterScope;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

class VariantFilter extends Component
{
    /**
     * @var Collection<int, string>
     */
    public Collection $variants;

    public string $variantInput;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $categoryId,
        ?string $brandId,
    ) {
        $this->variantInput = request()->string('variant')->toString();

        /** @phpstan-ignore-next-line */
        $this->variants = Variant::query()
            ->tap(VariantFilterScope::byCategory($categoryId)->asTap())
            ->tap(VariantFilterScope::byBrand($brandId)->asTap())
            ->distinct()
            ->pluck('name')
            ->filter();
    }

    #[Override]
    public function shouldRender(): bool
    {
        return $this->variants->isNotEmpty();
    }

    public function active(string $variant): bool
    {
        return $this->variantInput === $variant;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.product-toolbar.variant-filter');
    }
}
