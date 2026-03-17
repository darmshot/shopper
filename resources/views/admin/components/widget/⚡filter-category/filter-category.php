<?php

declare(strict_types=1);

use App\Models\Category;
use App\Services\Tree\Data\TreeCollection;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component
{
    #[Url(except: '', as: 'category_id')]
    public ?string $categoryId = '';

    public string $search = '';

    // store expanded nodes (for tree)
    public array $expanded = [];

    #[Computed]
    public function tree(): TreeCollection
    {
        return Category::repository()->tree();
    }

    #[Computed]
    public function filteredTree(): Collection
    {
        $tree = $this->tree();

        if ($this->search === '') {
            return $tree->limitDepth(2);
        }

        return $tree->searchTree($this->search);
    }

    /**
     * Todo rewrite method.
     */
    #[Computed]
    public function breadcrumbs(): array
    {
        if (! $this->categoryId) {
            return [];
        }

        $path = [];
        $current = Category::find($this->categoryId);

        while ($current) {
            $path[] = $current;
            $current = $current->parent;
        }

        return array_reverse($path);
    }

    public function updatedCategoryId(): void
    {
        $this->dispatch('apply', category_id: $this->categoryId);
    }
};
