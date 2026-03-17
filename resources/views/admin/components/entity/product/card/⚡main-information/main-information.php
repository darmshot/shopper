<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;
use App\Scopes\Eloquent\Queries\SortBrand;
use App\Services\Tree\Data\FlatCollection;
use App\Support\Form;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use \App\Support\Component\Concerns\DispatchesFieldUpdates;

    public string $name = '';

    public ?string $brandId = null;

    public bool $active = false;

    public bool $featured = false;

    /**
     * @var array<int, string|null>
     */
    public array $categories = [];

    public function mount(Product $product): void
    {
        $brandIdFromRequest = null;
        $categoriesFromRequest = null;

        if (request()->routeIs('admin.product.create')) {
            $brandIdFromRequest = request('brand_id');
            $categoriesFromRequest = when(request('category_id'), static function ($value) {
                return [$value];
            });
        }

        /** @var array<int, string> $categories */
        $categories = $product->categories->pluck('id')->toArray();

        $this->name = (string) Form::oldNullOrString('name', $product->name);
        $this->brandId = Form::oldNullOrString('brand_id', $product->brand_id) ?? $brandIdFromRequest;
        $this->active = Form::oldBool('active', (bool) $product->active);
        $this->featured = Form::oldBool('featured', (bool) $product->featured);
        /** @phpstan-ignore-next-line */
        $this->categories = (array) old('categories', $categories ?: $categoriesFromRequest ?? [null]);
    }

    #[Computed]
    public function categoryOptions(): FlatCollection
    {
        return Category::repository()->flatTree();
    }

    #[Computed]
    public function brandOptions(): Collection
    {
        return \App\Models\Brand::select('id', 'name')
            ->tap(new SortBrand()->asTap())
            ->get();
    }

    public function addCategory(): void
    {
        $this->categories[] = null;
    }

    public function removeCategory(int $index): void
    {
        unset($this->categories[$index]);
        // reindex
        $this->categories = array_values($this->categories);
    }
};
