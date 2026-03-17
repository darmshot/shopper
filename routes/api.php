<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.',
], function () {
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function () {
        /*
        |--------------------------------------------------------------------------
        | CATALOG
        |--------------------------------------------------------------------------
        */
        /*
         * Products
         */
        Route::post('products/{product}/duplicate',
            [\App\Http\Controllers\Api\Admin\ProductController::class, 'duplicate'])
            ->name('product.duplicate');

        Route::post('products/bulk-update',
            [\App\Http\Controllers\Api\Admin\ProductController::class, 'bulkUpdate'])
            ->name('product.bulk_update');

        Route::post('products/bulk-duplicate',
            [\App\Http\Controllers\Api\Admin\ProductController::class, 'bulkDuplicate'])
            ->name('product.bulk_duplicate');

        Route::post('products/bulk-delete',
            [\App\Http\Controllers\Api\Admin\ProductController::class, 'bulkDelete'])
            ->name('product.bulk_delete');

        Route::patch('products/{product}/variants/{variant}/update-price',
            [\App\Http\Controllers\Api\Admin\ProductVariantController::class, 'updatePrice'])
            ->name('product.variants.update_price');

        Route::patch('products/{product}/variants/{variant}/update-stock',
            [\App\Http\Controllers\Api\Admin\ProductVariantController::class, 'updateStock'])
            ->name('product.variants.update_stock');

        Route::patch('products/{product}', [\App\Http\Controllers\Api\Admin\ProductController::class, 'update'])
            ->name('product.update');

        Route::delete('products/{product}', [\App\Http\Controllers\Api\Admin\ProductController::class, 'destroy'])
            ->name('product.destroy');
        /*
         * Categories
         */
        Route::post('categories/bulk-update',
            [\App\Http\Controllers\Api\Admin\CategoryController::class, 'bulkUpdate'])
            ->name('category.bulk_update');

        Route::post('categories/bulk-delete',
            [\App\Http\Controllers\Api\Admin\CategoryController::class, 'bulkDelete'])
            ->name('category.bulk_delete');

        Route::post('categories/sort',
            [\App\Http\Controllers\Api\Admin\CategoryController::class, 'sort'])
            ->name('category.sort');

        Route::patch('categories/{category}', [\App\Http\Controllers\Api\Admin\CategoryController::class, 'update'])
            ->name('category.update');

        Route::delete('categories/{category}', [\App\Http\Controllers\Api\Admin\CategoryController::class, 'destroy'])
            ->name('category.destroy');
        /*
         * Brands
         */
        Route::post('brands/bulk-delete',
            [\App\Http\Controllers\Api\Admin\BrandController::class, 'bulkDelete'])
            ->name('brand.bulk_delete');

        Route::delete('brands/{brand}', [\App\Http\Controllers\Api\Admin\BrandController::class, 'destroy'])
            ->name('brand.destroy');
        /*
         * Features
         */
        Route::post('features/bulk-update',
            [\App\Http\Controllers\Api\Admin\FeatureController::class, 'bulkUpdate'])
            ->name('feature.bulk_update');

        Route::post('features/bulk-delete',
            [\App\Http\Controllers\Api\Admin\FeatureController::class, 'bulkDelete'])
            ->name('feature.bulk_delete');

        Route::patch('features/{feature}', [\App\Http\Controllers\Api\Admin\FeatureController::class, 'update'])
            ->name('feature.update');

        Route::delete('features/{feature}', [\App\Http\Controllers\Api\Admin\FeatureController::class, 'destroy'])
            ->name('feature.destroy');
    });
});
