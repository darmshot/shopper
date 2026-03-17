<?php

declare(strict_types=1);

use App\Models\Category;
use App\Services\Tree\Data\TreeCollection;
use App\Support\Form;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use \App\Support\Component\Concerns\DispatchesFieldUpdates;

    public string $name = '';

    public bool $active = false;

    public ?string $parentId = null;

    public ?string $categoryId = null;

    /**
     * @var array<int, string|null>
     */
    public array $categories = [];

    public function mount(Category $category): void
    {
        $this->categoryId = $category->id;
        $this->name = (string) Form::oldNullOrString('name', $category->name);
        $this->active = Form::oldBool('active', (bool) $category->active);
        /** @phpstan-ignore-next-line */
        $this->parentId = ((string) old('parent_id', $category->parent_id)) ?: null;
    }

    /**
     * @return TreeCollection<Category>
     */
    #[Computed]
    public function tree(): TreeCollection
    {
        return Category::repository()->tree();
    }
};
