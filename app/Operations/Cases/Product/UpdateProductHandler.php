<?php

declare(strict_types=1);

namespace App\Operations\Cases\Product;

use App\Exceptions\MediaStorageException;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Operations\Handlers\Product\SyncOptions;
use App\Operations\Handlers\Product\SyncProductWithCategories;
use App\Scopes\Eloquent\Queries\FilterCategory;
use App\Scopes\Eloquent\Queries\FilterFeature;
use App\Services\Media\ProductStorage;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class UpdateProductHandler
{
    public function __construct(
        private ProductStorage $storage,
    ) {}

    /**
     * @throws MediaStorageException
     * @throws Throwable
     */
    public function __invoke(UpdateProduct $command): void
    {
        $product = Product::findOrFail($command->id);

        $assignedCategories = Category::query()
            ->with(['parent'])
            ->tap(FilterCategory::byProduct($product->id)->asTap())
            ->get();

        $assigningCategories = Category::query()
            ->with(['parent'])
            ->tap(new FilterCategory(['id' => $command->categories])->asTap())
            ->get();

        $existsFeatures = Feature::query()
            ->tap(FilterFeature::byNames(array_column($command->newFeatures, 'name'))->asTap())
            ->get();

        DB::transaction(static function () use ($existsFeatures, $assigningCategories, $assignedCategories, $command, $product) {
            $syncProductWithCategories = new SyncProductWithCategories;
            $syncOptions = new SyncOptions;

            $product->update($command->attributes);

            $product->assignBrand($command->brandId);

            $product->syncRelated($command->related);

            $product->syncVariants($command->variants);

            $syncProductWithCategories(
                productId: $product->id,
                assignedCategories: $assignedCategories,
                assigningCategories: $assigningCategories,
                order: array_flip($command->categories)
            );

            $syncOptions(
                existsFeatures: $existsFeatures,
                newFeatures: $command->newFeatures,
                firstCategoryId: $command->firstCategoryId,
                options: $command->options,
                product: $product,
            );

            $product->deleteImages($command->deletedImages);
        });

        $this->storage->deleteImages($command->deletedImages);

        $this->storage->putImages($product->id, $command->droppedImages, static function (array $paths) use ($product) {
            $product->putImages($paths);
        });
    }
}
