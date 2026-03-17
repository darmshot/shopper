<?php

declare(strict_types=1);

namespace App\View\Design\Components\Widget;

use App\Models\Category;
use App\Services\Tree\Data\Node;
use App\Services\Tree\Data\TreeCollection;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
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
     * @param  Node<Category>  $node
     */
    public function renderNode(Node $node): string
    {
        $name = e($node->entity->name);
        $url = route('category.show', $node->entity->url);

        if ($node->children->isEmpty()) {
            $content = <<<HTML
                <a href="$url">$name</a>
                HTML;
        } else {
            $children = '';
            foreach ($node->children as $child) {
                $children .= $this->renderNode($child);
            }

            $content = <<<HTML
                <details>
                    <summary>$name</summary>
                    <ul>
                        <li>
                            <a href="$url">All products</a>
                        </li>
                        $children
                    </ul>
                </details>
                HTML;
        }

        return <<<HTML
            <li>
                $content
            </li>
            HTML;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('design.components.widget.menu');
    }
}
