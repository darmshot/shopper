<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

readonly class Currency
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request):((Response|RedirectResponse))  $next
     */
    public function handle(Request $request, Closure $next): RedirectResponse|Response
    {
        $currency = $request->header('Currency') ?? $request->input('_currency') ?? session('currency');

        if (empty($currency)) {
            return $next($request);
        }

        session(['currency' => $currency]);

        app()->setCurrency($currency);

        return $next($request);
    }
}
