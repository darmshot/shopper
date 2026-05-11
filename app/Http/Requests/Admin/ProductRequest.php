<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Http\Controllers\Admin\ProductController;
use App\Models\Product;
use App\Services\Media\Storage;
use App\Support\FormRequest\Concerns\HasPrice;
use App\Support\FormRequest\Concerns\HasStock;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Override;

class ProductRequest extends FormRequest
{
    use HasPrice;
    use HasStock;

    #[Override]
    protected function getRedirectUrl(): string
    {
        /** @phpstan-ignore-next-line */
        return match ($this->route()->hasParameter('product')) {
            true => action([ProductController::class, 'edit'], $this->routeProduct()),
            false => action([ProductController::class, 'create']),
        };
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => [
                'required', 'string', 'min:3', 'max:225',
                Rule::unique('products', 'url')
                    ->ignore($this->routeProduct()?->id),
            ],
            'name' => ['required', 'string', 'min:3', 'max:225'],
            'annotation' => ['nullable', 'string', 'min:3', 'max:225'],
            'description' => ['nullable', 'string', 'min:3', 'max:65000'],
            'active' => ['boolean'],
            'meta_title' => ['required', 'string', 'min:3', 'max:225'],
            'meta_description' => ['nullable', 'string', 'min:3', 'max:225'],
            'featured' => ['boolean'],
            'sort' => ['integer', 'min:0', 'max:4000000'],
            'brand_id' => ['nullable', 'uuid:7', 'exists:brands,id'],
            'related' => ['array'],
            'related.*' => ['required', 'uuid:7', 'exists:products,id'],
            'variants' => ['array', 'min:1'],
            'variants.*.sku' => ['required', 'string', 'min:3', 'max:255'],
            'variants.*.name' => ['nullable', 'string', 'min:3', 'max:255'],
            ...$this->priceRules('variants.*.price'),
            'variants.*.old_price' => ['nullable', 'decimal:0,2', 'decimal:0,2', 'min:1', 'max:900000000'],
            ...$this->stockRules('variants.*.stock'),
            'sort_variants' => ['array'],
            'sort_variants.*' => ['integer', 'min:0', 'max:4000000'],
            'options' => ['array'],
            'options.*.feature_id' => ['required', 'uuid:7', 'exists:features,id'],
            'options.*.value' => ['nullable', 'string', 'min:1', 'max:225'],
            'new_features.*.name' => ['required', 'string', 'min:3', 'max:225'],
            'new_features.*.value' => ['required', 'string', 'min:1', 'max:225'],
            'categories' => ['array', 'min:1'],
            'categories.*' => ['required', 'uuid:7', 'exists:categories,id'],
            'deleted_images' => ['array'],
            'deleted_images.*' => ['required', 'string', 'min:1', 'max:255'],
            'dropped_images' => ['array'],
            'dropped_images.*' => [
                'required',
                File::types(Storage::ALLOWED_IMAGE_EXTENSIONS)
                    ->min(1)
                    ->max(2 * 1024),
            ],
        ];
    }

    public function brandId(): ?string
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('brand_id');
    }

    /**
     * @return array<int,string>
     */
    public function related(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('related', []);
    }

    /**
     * @return array<int,array{
     * sku:string,
     * name:string|null,
     * price:float,
     * old_price:float|null,
     * stock:int|null,
     * sort:int|null}>
     */
    public function variants(): array
    {
        /** @var array<int,array{
         * sku:string,
         * name:string|null,
         * price:float,
         * old_price:float|null,
         * stock:int|null}> $variants
         */
        $variants = $this->validated('variants', []);

        /** @var array<int,string> $sortVariants */
        $sortVariants = $this->validated('sort_variants', []);

        foreach ($sortVariants as $sort => $index) {
            if (! isset($variants[$index])) {
                continue;
            }

            $variants[$index]['sort'] = $sort;
        }

        /** @phpstan-ignore-next-line */
        return $variants;
    }

    /**
     * @return array<int,string>
     */
    public function categories(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('categories', []);
    }

    public function firstCategoryId(): string
    {
        /** @phpstan-ignore-next-line */
        return array_first($this->validated('categories', []));
    }

    /**
     * @return array<int,array{feature_id:string,value:string}>
     */
    public function options(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('options', []);
    }

    /**
     * @return array<int,array{name:string,value:string}>
     */
    public function newFeatures(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('new_features', []);
    }

    /**
     * @return array<int, UploadedFile>
     */
    public function droppedImages(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('dropped_images', []);
    }

    /**
     * @return array<int,string> Paths
     */
    public function deletedImages(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('deleted_images', []);
    }

    private function routeProduct(): ?Product
    {
        /** @var Product|null $product */
        $product = $this->route('product');

        return $product;
    }
}
