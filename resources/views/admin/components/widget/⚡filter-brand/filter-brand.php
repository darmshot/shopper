<?php

declare(strict_types=1);

use App\Enums\Brand\Sort;
use App\Models\Brand;
use App\Scopes\Eloquent\Queries\FilterBrand;
use App\Scopes\Eloquent\Queries\SearchBrand;
use App\Scopes\Eloquent\Queries\SortBrand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[\Livewire\Attributes\Url(except: null, as: 'brand_id')]
    public ?string $brandId = null;

    public string $search = '';

    public bool $showAll = false;

    public ?string $categoryId = null;

    public function mount(): void
    {
        $this->categoryId = (string) request('category_id') ?: null;
    }

    public function updatedCategoryId(): void
    {
        $this->brandId = null;
    }

    public function updatedBrandId(): void
    {
        $this->dispatch('apply', brand_id: $this->brandId);
    }

    #[Computed]
    public function appendBrand(): ?string
    {
        return $this->search && $this->brandId ? $this->brandId : null;
    }

    #[Computed]
    public function brands(): Collection
    {
        return Brand::query()
            ->tap(new SearchBrand($this->search))
            ->tap(FilterBrand::byCategory($this->categoryId))
            ->tap(new SortBrand(Sort::NAME))
            ->when($this->appendBrand(),
                static fn (Builder $query, string $value) => $query->orWhere('id', $value))
            ->when($this->showAll === false, static fn (Builder $query) => $query->limit(10))
            ->get();
    }
};
