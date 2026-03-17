<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Api\BulkDeleteRequest;
use App\Http\Requests\Admin\Api\BulkUpdateFeatureRequest;
use App\Http\Requests\Admin\Api\UpdateFeatureRequest;
use App\Models\Feature;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class FeatureController extends Controller
{
    /**
     * @throws Throwable
     */
    public function update(UpdateFeatureRequest $request, Feature $feature): Response
    {
        DB::transaction(static function () use ($request, $feature) {
            dump($request->validated());
            $feature->update($request->validated());
        });

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(Feature $feature): Response
    {
        DB::transaction(static function () use ($feature) {
            $feature->delete();
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function bulkUpdate(BulkUpdateFeatureRequest $request): Response
    {
        $features = Feature::query()
            ->whereIn('id', $request->checked())
            ->get();

        DB::transaction(static function () use ($request, $features) {
            foreach ($features as $feature) {
                $feature->update($request->validated());
            }
        });

        return response()->noContent();
    }

    /**
     * @throws Throwable
     */
    public function bulkDelete(BulkDeleteRequest $request): Response
    {
        $features = Feature::query()
            ->whereIn('id', $request->checked())
            ->get();

        DB::transaction(static function () use ($features) {
            foreach ($features as $feature) {
                $feature->delete();
            }
        });

        return response()->noContent();
    }
}
