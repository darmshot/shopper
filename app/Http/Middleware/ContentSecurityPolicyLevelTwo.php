<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContentSecurityPolicyLevelTwo
{
    /**
     * Handle an incoming request.
     *
     * No inline JS
     * No eval
     * No dynamic expressions
     * → Alpine regular build breaks
     * → Alpine CSP build required
     *
     * @param  Closure(Request):((Response|RedirectResponse))  $next
     */
    public function handle(Request $request, Closure $next): RedirectResponse|Response
    {
        $response = $next($request);

        // Skip when vite dev mode.
        if (app()->environment('local')) {
            // Allow Vite dev server + HMR
            $response->headers->set(
                'Content-Security-Policy',
                "script-src 'self' http://localhost:5173 'unsafe-eval'; ".
                "connect-src 'self' ws://localhost:5173 http://localhost:5173;"
            );

            return $response;
        }

        $response->headers->set('Content-Security-Policy',
            "script-src 'self';",
        );

        return $response;
    }
}
