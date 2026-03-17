<?php

declare(strict_types=1);

use App\Models\Product;
use App\Scopes\Eloquent\Queries\FilterProduct;
use App\Scopes\Eloquent\Queries\SearchProduct;
use App\Scopes\Eloquent\Queries\SortProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use \Livewire\WithPagination;

    #[\Livewire\Attributes\Url(except: '')]
    public ?string $search = '';

    public ?string $filter = null;

    public ?string $brandId = null;

    public ?string $categoryId = null;

    public Collection $headStack;

    public function mount(): void
    {
        $this->filter = (string) request('filter') ?: null;
        $this->brandId = (string) request('brand_id') ?: null;
        $this->categoryId = (string) request('category_id') ?: null;
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['filter', 'brandId', 'categoryId', 'search'])) {
            $this->resetPage();
        }
    }

    #[Computed]
    public function products(): LengthAwarePaginator
    {
        return Product::query()
            ->with(['categories'])
            ->tap(new SearchProduct($this->search))
            ->tap(FilterProduct::byFilter($this->filter)->asTap())
            ->tap(FilterProduct::byCategory($this->categoryId)->asTap())
            ->tap(FilterProduct::byBrand($this->brandId)->asTap())
            ->tap(new SortProduct)
            ->with(['variants'])
            ->withCount(['variants'])
            ->paginate(perPage: 100);
    }
};
