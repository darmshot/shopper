<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BrandController;
use App\Models\Brand;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('store brand. full valid form', function (array $attributes) {

    $image = UploadedFile::fake()->image('photo1.jpg')->size(256);
    $response = post(action([BrandController::class, 'store']), [
        ...$attributes,
        'image' => null,
        'dropped_image' => $image,
        'not_exists_field' => 'value',
    ]);

    $response->assertValid();

    $response->assertRedirect();

    assertDatabaseHas('brands', [
        'name' => $attributes['name'],
    ]);

    assertDatabaseCount('brands', 1);
})
    ->with('brand fillable attributes');

test('update brand. full valid form', function (array $attributes) {
    $images = [
        UploadedFile::fake()->image('photo1.jpg')->size(256),
        UploadedFile::fake()->image('photo2.jpg')->size(256),
    ];

    $brand = Brand::factory()
        ->state([
            'image' => $images[0]->path(),
        ])
        ->create();

    $response = put(action([BrandController::class, 'update'], ['brand' => $brand->id]), [
        ...$attributes,
        'not_exists_field' => 'value',
        'image' => null,
        'dropped_image' => $images[1],
    ]);

    $response->assertValid();

    $response->assertRedirect();

    assertDatabaseHas('brands', [
        'name' => $attributes['name'],
    ]);

    assertDatabaseCount('brands', 1);
})
    ->with('brand fillable attributes');
