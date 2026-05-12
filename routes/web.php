<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::redirect('', '/admin/product');
    Route::resource('product', \App\Http\Controllers\Admin\ProductController::class)->except(['show', 'destroy']);
    Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class)->except(['show', 'destroy']);
    Route::resource('brand', \App\Http\Controllers\Admin\BrandController::class)->except(['show', 'destroy']);
    Route::resource('feature', \App\Http\Controllers\Admin\FeatureController::class)->except(['show', 'destroy']);
});

Route::group([
    'middleware' => [
        \App\Http\Middleware\ContentSecurityPolicyLevelTwo::class,
    ],
], function () {
    Route::view('/', 'design.home')
        ->name('home');

    Route::view('catalog', 'design.catalog')
        ->name('catalog');

    Route::view('catalog/discounts', 'design.discounts')
        ->name('discounts');

    Route::get('catalog/{category:url}', [\App\Http\Controllers\CategoryController::class, 'show'])
        ->name('category.show');

    Route::view('/brands', 'design.brands')
        ->name('brands');

    Route::get('brands/{brand:url}', [\App\Http\Controllers\BrandController::class, 'show'])
        ->name('brand.show');

    Route::get('product/{product:url}', [\App\Http\Controllers\ProductController::class, 'show'])
        ->name('product.show');

});
