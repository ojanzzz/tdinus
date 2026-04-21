<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Honeypot
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!config('honeypot.enabled')) {
            return $next($request);
        }

        // Check honeypot field
        $honeypotField = config('honeypot.field_name');
        if ($request->has($honeypotField) && !empty($request->input($honeypotField))) {
            $this->logSpamAttempt($request, 'honeypot_field_filled');
            return response()->json([
                'message' => config('honeypot.response_message')
            ], 422);
        }

        // Check submission time
        $timeField = config('honeypot.time_field');
        if ($request->has($timeField)) {
            $submittedTime = $request->input($timeField);
            $minTime = config('honeypot.min_time');

            if (time() - $submittedTime < $minTime) {
                $this->logSpamAttempt($request, 'too_fast_submission');
                return response()->json([
                    'message' => 'Form submitted too quickly. Please wait and try again.'
                ], 422);
            }
        }

        return $next($request);
    }

    /**
     * Log spam attempt.
     */
    protected function logSpamAttempt(Request $request, string $reason): void
    {
        if (config('honeypot.log_spam')) {
            Log::warning('Spam attempt detected', [
                'reason' => $reason,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'input' => $request->except(['password', 'password_confirmation']),
                'timestamp' => now()->toDateTimeString()
            ]);
        }
    }
}
