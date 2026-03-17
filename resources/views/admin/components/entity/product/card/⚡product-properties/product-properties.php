<?php

declare(strict_types=1);

use App\Models\Feature;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public array $newFeatures = [];

    public ?string $mainCategoryId = null;

    public array $options = [];

    private const array NEW_FEATURE_TEMPLATE = [
        'name' => null,
        'value' => null,
    ];

    public function mount(Product $product): void
    {
        $this->mainCategoryId = $product->categories->first()?->id;
        $this->newFeatures = old('new_features', []);

        $oldOptions = old('options');

        $options = \App\Models\Option::query()
            ->where('product_id', $product->id)
            ->get()
            ->keyBy('feature_id')
            ->toArray();

        foreach ($this->features as $index => $feature) {
            // Get option from request
            if ($oldOptions && isset($oldOptions[$index])) {
                $this->options[$index] = $oldOptions[$index];
                // Get option from store
            } elseif (isset($options[$feature->id])) {
                $this->options[$index] = $options[$feature->id];
                // Create template of option
            } else {
                $this->options[$index] = [
                    'feature_id' => $feature->id,
                    'value' => null,
                ];
            }
        }
    }

    #[Computed]
    public function features(): Collection
    {
        if (empty($this->mainCategoryId)) {
            return collect();
        }

        $mainCategoryId = $this->mainCategoryId;

        return Feature::select('id', 'name')
            ->whereHas('categories', static function (Builder $query) use ($mainCategoryId) {
                $query->where('category_id', $mainCategoryId);
            })
            ->orderBy('name')
            ->get();
    }

    public function addNewFeature(): void
    {
        $this->newFeatures[] = [self::NEW_FEATURE_TEMPLATE];
    }

    public function removeNewFeature(int $index): void
    {
        unset($this->newFeatures[$index]);
        $this->newFeatures = array_values($this->newFeatures);
    }
};
