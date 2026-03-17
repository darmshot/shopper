<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exceptions\MediaStorageException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Services\Media\ProductStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.products');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(ProductRequest $request, ProductStorage $storage): RedirectResponse
    {
        $product = new Product($request->validated());
        DB::transaction(static function () use ($request, &$product) {
            $product->save();

            $product->assignBrand($request->brandId());

            $product->syncRelated($request->related());

            $product->saveVariants($request->variants());

            Category::syncProductWithCategories($product->id, $request->categories());

            $newOptions = [];
            foreach ($request->newFeatures() as $newFeature) {
                $feature = Feature::firstOrCreate([
                    'name' => $newFeature['name'],
                ]);

                $feature->attachCategory($request->firstCategoryId());

                $newOptions[] = ['feature_id' => $feature->id, 'value' => $newFeature['value']];
            }

            $product->syncOptions([
                ...$request->options(),
                ...$newOptions,
            ]);
        });

        $storage->putImages($product->id, $request->droppedImages(), static function (array $paths) use ($product) {
            $product->putImages($paths);
        });

        session()->flash('success', __('status.success_created', ['entity' => __('product.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('admin.product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws MediaStorageException
     * @throws Throwable
     */
    public function update(ProductRequest $request, Product $product, ProductStorage $storage): RedirectResponse
    {
        DB::transaction(static function () use ($request, $product) {
            $product->update($request->validated());

            $product->assignBrand($request->brandId());

            $product->syncRelated($request->related());

            $product->syncVariants($request->variants());

            Category::syncProductWithCategories($product->id, $request->categories());

            $newOptions = [];
            foreach ($request->newFeatures() as $newFeature) {
                $feature = Feature::firstOrCreate([
                    'name' => $newFeature['name'],
                ]);

                $feature->attachCategory($request->firstCategoryId());

                $newOptions[] = ['feature_id' => $feature->id, 'value' => $newFeature['value']];
            }

            $product->syncOptions([
                ...$request->options(),
                ...$newOptions,
            ]);

            $product->deleteImages($request->deletedImages());
        });

        $storage->deleteImages($request->deletedImages());

        $storage->putImages($product->id, $request->droppedImages(), static function (array $paths) use ($product) {
            $product->putImages($paths);
        });

        session()->flash('success', __('status.success_updated', ['entity' => __('product.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $product);
    }
}
