<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Api\UpdatePriceProductVariantRequest;
use App\Http\Requests\Admin\Api\UpdateStockProductVariantRequest;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductVariantController extends Controller
{
    /**
     * @throws Throwable
     */
    public function updatePrice(UpdatePriceProductVariantRequest $request, Product $product, string $variant): Response
    {
        DB::transaction(static function () use ($request, $product, $variant) {
            $product->updateVariant($variant, $request->validated());
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function updateStock(UpdateStockProductVariantRequest $request, Product $product, string $variant): Response
    {
        DB::transaction(static function () use ($request, $product, $variant) {
            $product->updateVariant($variant, $request->validated());
        });

        return response()->noContent();
    }
}
