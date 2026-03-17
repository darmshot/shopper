<?php

declare(strict_types=1);

use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public Product $product;

    public string $searchRelated;

    public array $suggestRelated;

    public array $related;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->related = old('related') ?? $product
            ->related()
            ->orderBy('product_related.sort')
            ->pluck('id')
            ->toArray();
    }

    #[Computed]
    public function relatedCollection(): Collection
    {
        if (empty($this->related)) {
            return collect();
        }

        return Product::query()
            ->whereIn('id', $this->related)
            ->select('id', 'images', 'name')
            ->get()
            ->keyBy('id');
    }

    public function updatedSearchRelated(string $query): void
    {
        if (strlen($query) < 2) {
            $this->suggestRelated = [];

            return;
        }

        $this->suggestRelated = Product::query()
            ->where('name', 'like', "%{$query}%")
            ->where('id', '!=', $this->product->id)
            ->select('id', 'name', 'images')
            ->limit(10)
            ->get()
            ->append('image')
            ->toArray();
    }

    public function addRelated(string $productId): void
    {
        if (! in_array($productId, $this->related, true)) {
            $this->related[] = $productId;
        }

        // Clear search and suggestions
        $this->searchRelated = '';
        $this->suggestRelated = [];
    }

    public function removeRelated(string $id): void
    {
        $key = array_search($id, $this->related);

        unset($this->related[$key]);
    }

    public function reorderRelated(array $ids): void
    {
        // Map existing related IDs to preserve only valid ones
        $existing = collect($this->related)->flip();

        // Rebuild in the new order
        $this->related = collect($ids)
            ->filter(fn ($id) => $existing->has($id))
            ->values()
            ->all();
    }
};
