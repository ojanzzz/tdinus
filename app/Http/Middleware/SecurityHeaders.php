<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Content Security Policy - FIXED CSP syntax + added 'unsafe-eval' for JS encodeURIComponent
        $csp = "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://code.jquery.com https://cdn.tiny.cloud https://www.tiny.cloud; " .
"style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tiny.cloud https://www.tiny.cloud; " .
            "font-src 'self' https://fonts.gstatic.com https://cdn.tiny.cloud https://www.tiny.cloud; " .

            "img-src 'self' data: https:; " .
"connect-src 'self' https://www.tiny.cloud https://cdn.tiny.cloud; " .
            "frame-ancestors 'none'; " .

            "base-uri 'self'; " .
            "form-action 'self';";

        
        $response->headers->set('Content-Security-Policy', $csp);

        // Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy
        $response->headers->set('Permissions-Policy',
'geolocation=(), microphone=(), camera=(), magnetometer=(), gyroscope=(), fullscreen=()'
        );

        // HSTS (HTTP Strict Transport Security) - only in production
        if (config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }
}

