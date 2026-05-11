<?php

declare(strict_types=1);

namespace App\Operations\Handlers\Product;

use App\Models\Feature;
use App\Models\Product;
use Illuminate\Support\Collection;

class SyncOptions
{
    /**
     * @param  Collection<int, Feature>  $existsFeatures
     * @param  array<int,array{name:string,value:string}>  $newFeatures
     * @param  array<int,array{feature_id:string,value:string}>  $options
     */
    public function __invoke(
        Collection $existsFeatures,
        array $newFeatures,
        string $firstCategoryId,
        array $options,
        Product $product,
    ): void {
        $existsFeaturesByName = $existsFeatures->keyBy('id');

        $newOptions = [];
        foreach ($newFeatures as $newFeature) {
            $feature = $existsFeaturesByName->get($newFeature['name']);
            if (empty($feature)) {
                $feature = Feature::create([
                    'name' => $newFeature['name'],
                ]);
            }

            $feature->attachCategory($firstCategoryId);

            $newOptions[] = ['feature_id' => $feature->id, 'value' => $newFeature['value']];
        }

        $product->syncOptions([
            ...$options,
            ...$newOptions,
        ]);
    }
}
