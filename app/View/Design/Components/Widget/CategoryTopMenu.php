<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget;

use App\Models\Category;
use App\Services\Tree\Data\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryTopMenu extends Component
{
    /**
     * @var Menu<Category>
     */
    public Menu $menu;

    private readonly ?string $sort;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $categoryId = null,
    ) {
        $this->sort = request()->string('sort')->toString() ?: null;

        $this->menu = Category::repository()->menu($this->categoryId);
    }

    public function route(string $url): string
    {
        return route('category.show', ['category' => $url, 'sort' => $this->sort]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.category-top-menu');
    }
}
