<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    public function active(string $name): bool
    {
        return match ($name) {
            'catalog' => request()->routeIs('category.show', 'catalog', 'product.show', 'brand.show'),
            default => request()->routeIs($name),
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.navbar');
    }
}
