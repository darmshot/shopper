<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScopeActiveEntities
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Product::addGlobalScope('active', static function ($query) {
            $query->where('active', true);
        });

        Product::addGlobalScope('with_variants', static function ($query) {
            $query->has('variants');
        });

        return $next($request);
    }
}
