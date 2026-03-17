<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeatureRequest;
use App\Models\Feature;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.features');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.feature');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(FeatureRequest $request): RedirectResponse
    {
        $feature = null;

        DB::transaction(static function () use ($request, &$feature) {
            $feature = Feature::create($request->validated());

            $feature->syncCategories($request->categories());
        });

        session()->flash('success', __('status.success_created', ['entity' => __('feature.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $feature);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature): View
    {
        return view('admin.feature', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(FeatureRequest $request, Feature $feature): RedirectResponse
    {
        DB::transaction(static function () use ($request, $feature) {
            $feature->update($request->validated());

            $feature->syncCategories($request->categories());
        });

        session()->flash('success', __('status.success_updated', ['entity' => __('feature.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $feature);
    }
}
