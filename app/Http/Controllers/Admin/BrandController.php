<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exceptions\MediaStorageException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use App\Services\Media\BrandStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.brands');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.brand');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws MediaStorageException
     * @throws Throwable
     */
    public function store(BrandRequest $request, BrandStorage $storage): RedirectResponse
    {
        $brand = new Brand($request->validated());

        DB::transaction(static function () use (&$brand) {
            $brand->save();
        });

        if ($file = $request->droppedImage()) {
            $storage->putImage($brand->id, $file, static function (string $path) use ($brand) {
                $brand->putImage($path);
            });
        }

        session()->flash('success', __('status.success_created', ['entity' => __('brand.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $brand);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand): View
    {
        return view('admin.brand', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws MediaStorageException
     * @throws Throwable
     */
    public function update(BrandRequest $request, Brand $brand, BrandStorage $storage): RedirectResponse
    {
        DB::transaction(static function () use ($request, $brand) {
            $brand->update($request->validated());
        });

        if ($file = $request->droppedImage()) {
            $storage->putImage($brand->id, $file, static function (string $path) use ($brand) {
                $brand->putImage($path);
            });
        }

        if ($request->deleteImage() && $brand->image) {
            $storage->deleteImage($brand->image);
            $brand->deleteImage();
        }

        session()->flash('success', __('status.success_updated', ['entity' => __('brand.entity_name_singular')]));

        return redirect()->action([self::class, 'edit'], $brand);
    }
}
