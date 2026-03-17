<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Contracts\View\View;

class BrandController extends Controller
{
    public function show(Brand $brand): View
    {
        return view('design.brand', compact('brand'));
    }
}
