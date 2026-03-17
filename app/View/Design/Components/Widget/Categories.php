<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget;

use App\Models\Category;
use App\Services\Tree\Data\TreeCollection;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Categories extends Component
{
    /**
     * @var TreeCollection<Category>
     */
    public TreeCollection $categories;

    /**
     * Create a new component instance.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->categories = Category::repository()->tree();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.categories');
    }
}
