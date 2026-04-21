<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LoginThrottle
{
    /**
     * The rate limiter instance.
     */
    protected RateLimiter $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $this->resolveRequestSignature($request);

        // Allow 5 attempts per minute, then lock for 15 minutes
        if ($this->limiter->tooManyAttempts($key, 5)) {
            $seconds = $this->limiter->availableIn($key);

            return response()->json([
                'message' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',
                'retry_after' => $seconds
            ], 429)->header('Retry-After', $seconds);
        }

        $this->limiter->hit($key, 900); // 15 minutes decay

        $response = $next($request);

        // Clear throttle on successful login
        if ($response->getStatusCode() === 302 && $request->session()->has('auth.password_confirmed_at')) {
            $this->limiter->clear($key);
        }

        return $response;
    }

    /**
     * Resolve request signature.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        $email = $request->input('email', 'unknown');

        return sha1($email . '|' . $request->ip());
    }
}
