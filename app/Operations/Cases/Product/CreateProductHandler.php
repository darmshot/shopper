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

readonly class CreateProductHandler
{
    public function __construct(
        private ProductStorage $storage,
    ) {}

    /**
     * @throws Throwable
     * @throws MediaStorageException
     */
    public function __invoke(
        CreateProduct $command
    ): void {
        $product = new Product($command->attributes);
        $product->id = $command->newId;

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

        DB::transaction(static function () use ($existsFeatures, $assigningCategories, $command, &$product, $assignedCategories) {
            $syncProductWithCategories = new SyncProductWithCategories;
            $syncOptions = new SyncOptions;

            $product->save();

            $product->assignBrand($command->brandId);

            $product->syncRelated($command->related);

            $product->saveVariants($command->variants);

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
        });

        $this->storage->putImages(
            entityId: $product->id,
            files: $command->droppedImages,
            callback: static function (array $paths) use ($product) {
                $product->putImages($paths);
            });
    }
}
