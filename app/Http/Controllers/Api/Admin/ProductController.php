<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Api\BulkDeleteRequest;
use App\Http\Requests\Admin\Api\BulkDuplicateProductRequest;
use App\Http\Requests\Admin\Api\BulkUpdateProductRequest;
use App\Http\Requests\Admin\Api\UpdateProductRequest;
use App\Models\Product;
use App\Services\Media\ProductStorage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    /**
     * @throws Throwable
     */
    public function update(UpdateProductRequest $request, Product $product): Response
    {
        DB::transaction(static function () use ($request, $product) {
            $product->update($request->validated());
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function duplicate(Product $product, ProductStorage $storage): Response
    {
        $replica = null;
        DB::transaction(static function () use ($product, &$replica) {
            $product->duplicate(function (Product $copy) use (&$replica) {
                $replica = $copy;
            });
        });

        if ($replica) {
            $storage->duplicate($product->id, $replica->id);
            $replica->putImages($storage->allFiles($replica->id));
        }

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(Product $product): Response
    {
        DB::transaction(static function () use ($product) {
            $product->delete();
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function bulkUpdate(BulkUpdateProductRequest $request): Response
    {
        $products = Product::query()
            ->whereIn('id', $request->checked())
            ->get();

        DB::transaction(static function () use ($request, $products) {
            foreach ($products as $product) {
                $product->update($request->validated());
            }
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function bulkDuplicate(BulkDuplicateProductRequest $request): Response
    {
        $products = Product::query()
            ->whereIn('id', $request->checked())
            ->get();

        DB::transaction(static function () use ($products) {
            foreach ($products as $product) {
                $product->duplicate();
            }
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function bulkDelete(BulkDeleteRequest $request): Response
    {
        $products = Product::query()
            ->whereIn('id', $request->checked())
            ->get();

        DB::transaction(static function () use ($products) {
            foreach ($products as $product) {
                $product->delete();
            }
        });

        return response()->noContent();
    }
}
