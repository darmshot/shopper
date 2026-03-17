<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Api\BulkDeleteRequest;
use App\Models\Brand;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class BrandController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(Brand $brand): Response
    {
        DB::transaction(static function () use ($brand) {
            $brand->delete();
        });

        return response()->noContent();
    }

    /**
     * Remove checked resources.
     *
     * @throws Throwable
     */
    public function bulkDelete(BulkDeleteRequest $request): Response
    {
        $categories = Brand::query()
            ->whereIn('id', $request->checked())
            ->get();

        DB::transaction(static function () use ($categories) {
            foreach ($categories as $brand) {
                $brand->delete();
            }
        });

        return response()->noContent();
    }
}
