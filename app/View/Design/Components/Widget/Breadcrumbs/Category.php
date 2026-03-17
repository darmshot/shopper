<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget\Breadcrumbs;

use App\Models\Category as CategoryModel;
use App\Services\Tree\Data\TreeCollection;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

class Category extends Component
{
    /**
     * @var TreeCollection<CategoryModel>
     */
    public TreeCollection $categories;

    /**
     * Create a new component instance.
     *
     * @throws Exception
     */
    public function __construct(
        string $categoryId,
        public bool $withLastRoute = false,
    ) {
        $this->categories = CategoryModel::repository()
            ->parentsWithSelf($categoryId);
    }

    #[Override]
    public function shouldRender(): bool
    {
        return $this->categories->isNotEmpty();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.breadcrumbs.category');
    }
}
