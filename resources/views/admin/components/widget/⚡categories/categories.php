<?php

declare(strict_types=1);

use App\Models\Category;
use App\Services\Tree\Data\TreeCollection;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[\Livewire\Attributes\Url(except: '')]
    public ?string $search = '';

    public function mount(): void
    {
        //
    }

    #[Computed]
    public function tree(): TreeCollection
    {
        return Category::repository()
            ->tree();
    }

    #[Computed]
    public function categories(): Collection
    {
        return Category::repository()
            ->tree()
            ->searchTree($this->search)
            ->flatTree();
    }
};
