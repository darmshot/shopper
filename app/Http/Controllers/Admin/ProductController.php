<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exceptions\MediaStorageException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Operations\Cases\Product\CreateProduct;
use App\Operations\Cases\Product\CreateProductHandler;
use App\Operations\Cases\Product\UpdateProduct;
use App\Operations\Cases\Product\UpdateProductHandler;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
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
     * @throws MediaStorageException
     * @throws Throwable
     */
    public function store(ProductRequest $request, CreateProductHandler $handler): RedirectResponse
    {
        $newId = Str::uuid7()->toString();

        $handler(new CreateProduct(
            newId: $newId,
            attributes: $request->validated(),
            related: $request->related(),
            brandId: $request->brandId(),
            variants: $request->variants(),
            categories: $request->categories(),
            newFeatures: $request->newFeatures(),
            firstCategoryId: $request->firstCategoryId(),
            options: $request->options(),
            droppedImages: $request->droppedImages(),
        ));

        session()->flash('success', __('status.success_created', ['entity' => __('product.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $newId);
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
     * @throws Throwable
     * @throws MediaStorageException
     */
    public function update(ProductRequest $request, Product $product, UpdateProductHandler $handler): RedirectResponse
    {
        $handler(new UpdateProduct(
            id: $product->id,
            attributes: $request->validated(),
            related: $request->related(),
            brandId: $request->brandId(),
            variants: $request->variants(),
            categories: $request->categories(),
            newFeatures: $request->newFeatures(),
            firstCategoryId: $request->firstCategoryId(),
            options: $request->options(),
            droppedImages: $request->droppedImages(),
            deletedImages: $request->deletedImages(),
        ));

        session()->flash('success', __('status.success_updated', ['entity' => __('product.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $product);
    }
}
