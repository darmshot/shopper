<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Scopes\Eloquent\Queries\SearchBrand;
use App\Scopes\Eloquent\Queries\SortBrand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use \Livewire\WithPagination;

    #[\Livewire\Attributes\Url(except: '')]
    public ?string $search = '';

    public function mount(): void
    {
        //
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function brands(): LengthAwarePaginator
    {
        return Brand::tap(new SortBrand)
            ->tap(new SearchBrand($this->search))
            ->paginate(perPage: 100);
    }
};
