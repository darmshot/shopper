<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\Media\CategoryStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.categories');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(CategoryRequest $request, CategoryStorage $storage): RedirectResponse
    {
        $category = new Category($request->validated());

        DB::transaction(static function () use ($request, &$category) {
            $category->save();

            $category->assignParent($request->parentId());
        });

        if ($file = $request->droppedImage()) {
            $storage->putImage($category->id, $file, static function (string $image) use ($category) {
                $category->putImage($image);
            });
        }

        session()->flash('success', __('status.success_created', ['entity' => __('category.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('admin.category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(CategoryRequest $request, Category $category, CategoryStorage $storage): RedirectResponse
    {
        DB::transaction(static function () use ($request, $category) {
            $category->update($request->validated());

            $category->assignParent($request->parentId());
        });

        if ($file = $request->droppedImage()) {
            $storage->putImage($category->id, $file, static function (string $path) use ($category) {
                $category->putImage($path);
            });
        }

        if ($request->deleteImage() && $category->image) {
            $storage->deleteImage($category->image);
            $category->deleteImage();
        }

        session()->flash('success', __('status.success_updated', ['entity' => __('category.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $category);
    }
}
