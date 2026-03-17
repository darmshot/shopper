<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Api\BulkDeleteRequest;
use App\Http\Requests\Admin\Api\BulkUpdateCategoryRequest;
use App\Http\Requests\Admin\Api\SortCategoryRequest;
use App\Http\Requests\Admin\Api\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryController extends Controller
{
    /**
     * @throws Throwable
     */
    public function update(UpdateCategoryRequest $request, Category $category): Response
    {
        DB::transaction(static function () use ($request, $category) {
            $category->update($request->validated());
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function sort(SortCategoryRequest $request): Response
    {
        $categories = Category::query()
            ->whereIn('id', $request->getItemIds())
            ->get();

        DB::transaction(static function () use ($request, $categories) {
            foreach ($categories as $category) {
                $item = $request->getItem($category->id);
                if ($item) {
                    $category->update($item);
                }
            }
        });

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(Category $category): Response
    {
        DB::transaction(static function () use ($category) {
            $category->delete();
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function bulkUpdate(BulkUpdateCategoryRequest $request): Response
    {
        $categories = Category::query()
            ->whereIn('id', $request->checked())
            ->get();

        DB::transaction(static function () use ($request, $categories) {
            foreach ($categories as $category) {
                $category->update($request->validated());
            }
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function bulkDelete(BulkDeleteRequest $request): Response
    {
        $categories = Category::query()
            ->whereIn('id', $request->checked())
            ->get();

        DB::transaction(static function () use ($categories) {
            foreach ($categories as $category) {
                $category->delete();
            }
        });

        return response()->noContent();
    }
}
