<?php

declare(strict_types=1);

use App\Models\Feature;
use App\Scopes\Eloquent\Queries\FilterFeature;
use App\Scopes\Eloquent\Queries\SearchFeature;
use App\Scopes\Eloquent\Queries\SortFeature;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use \Livewire\WithPagination;

    #[\Livewire\Attributes\Url(except: '')]
    public ?string $search = '';

    private array $filters = [];

    public ?string $categoryId = null;

    public function mount(): void
    {
        $this->categoryId = (string) request('category_id') ?: null;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryId(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function features(): LengthAwarePaginator
    {
        return Feature::tap(new SearchFeature($this->search))
            ->tap(new SortFeature)
            ->tap(FilterFeature::byCategory($this->categoryId))
            ->paginate(perPage: 100);
    }
};
