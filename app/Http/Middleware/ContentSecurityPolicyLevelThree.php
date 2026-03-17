<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContentSecurityPolicyLevelThree
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request):((Response|RedirectResponse))  $next
     */
    public function handle(Request $request, Closure $next): RedirectResponse|Response
    {
        $response = $next($request);

        $response->headers->set('Content-Security-Policy',
            "script-src 'self'; object-src 'none'; base-uri 'self';"
        );

        return $response;
    }
}
