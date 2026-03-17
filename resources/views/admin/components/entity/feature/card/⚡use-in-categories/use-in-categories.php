<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Feature;
use App\Services\Tree\Data\FlatCollection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    /**
     * @var array<int, string>
     */
    public array $categories = [];

    public function mount(Feature $feature): void
    {
        /** @var array<int, string> $categories */
        $categories = $feature->categories->pluck('id')->toArray();

        /** @phpstan-ignore-next-line */
        $this->categories = (array) old('categories', $categories);
    }

    /**
     * @return FlatCollection<Category>
     */
    #[Computed]
    public function categoryOptions(): FlatCollection
    {
        return Category::repository()->flatTree();
    }
};
