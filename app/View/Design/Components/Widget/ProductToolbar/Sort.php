<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget\ProductToolbar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sort extends Component
{
    public ?string $sort = null;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $input = request()->string('sort')->toString();

        $this->sort = \App\Enums\Product\Sort::tryCatalogMatch($input)?->toCatalog();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.product-toolbar.sort');
    }
}
