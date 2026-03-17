<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CategoryController;
use App\Models\Category;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function PHPUnit\Framework\assertNotNull;

test('store category. valid form', function (array $attributes) {
    $parent = Category::factory()->create();

    $response = post(action([CategoryController::class, 'store']), [
        ...$attributes,
        'parent_id' => $parent->id,
        'not_exists_field' => 'value',
        'dropped_image' => UploadedFile::fake()->image('photo1.jpg')->size(256),
    ]);

    $response->assertValid();

    $response->assertRedirect();

    $category = Category::query()
        ->where('url', $attributes['url'])
        ->first();

    assertDatabaseHas('categories', [
        'parent_id' => $parent->id,
        'name' => $attributes['name'],
    ]);

    expect($category?->parent_id)
        ->toBe($parent->id)
        ->and($category?->name)->toBe($attributes['name']);

    assertDatabaseHas('categories', [
        'parent_id' => $parent->id,
        'name' => $attributes['name'],
    ]);

    assertDatabaseCount('categories', 2);
})
    ->with('category fillable attributes');

test('update category. valid form', function (array $attributes) {
    $newImage = UploadedFile::fake()->image('photo2.jpg')->size(256);

    $category = Category::factory()
        ->for(Category::factory(), 'parent')
        ->create();

    $parent = Category::factory()->create();

    $response = put(action([CategoryController::class, 'update'], ['category' => $category->id]), [
        ...$attributes,
        'parent_id' => $parent->id,
        'dropped_image' => $newImage,
        'not_exists_field' => 'value',
    ]);

    $response->assertValid();

    $response->assertRedirect();

    assertDatabaseHas('categories', [
        'parent_id' => $parent->id,
        'name' => $attributes['name'],
    ]);

    assertNotNull(
        Category::where('name', $attributes['name'])->value('image')
    );

    assertDatabaseCount('categories', 3);
})
    ->with('category fillable attributes');

test('update category. valid form. drop image', function (array $attributes) {
    $image = UploadedFile::fake()->image('photo1.jpg')->size(256);

    $category = Category::factory()
        ->state([
            'image' => $image->path(),
        ])
        ->create();

    $response = put(action([CategoryController::class, 'update'], ['category' => $category->id]), [
        ...$attributes,
        'deleted_image' => true,
    ]);

    $response->assertValid();

    $response->assertRedirect();

    assertDatabaseHas('categories', [
        'name' => $attributes['name'],
        'image' => null,
    ]);

    assertDatabaseCount('categories', 1);
})
    ->with('category fillable attributes');
