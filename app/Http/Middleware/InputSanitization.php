<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InputSanitization
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sanitize all input data
        $input = $request->all();

        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                // Remove null bytes
                $value = str_replace("\0", '', $value);

                // Remove potentially dangerous characters but keep basic punctuation
                $value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

                // Trim whitespace
                $value = trim($value);

                // Limit string length to prevent buffer overflow
                if (strlen($value) > 10000) {
                    $value = substr($value, 0, 10000);
                }
            }
        });

        // Replace the request input with sanitized data
        $request->merge($input);

        // Check for suspicious patterns
        $this->checkForSuspiciousPatterns($request);

        return $next($request);
    }

    /**
     * Check for suspicious patterns in the request.
     */
    protected function checkForSuspiciousPatterns(Request $request): void
    {
        $suspiciousPatterns = [
            '/<script/i',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload=/i',
            '/onerror=/i',
            '/eval\(/i',
            '/base64_decode/i',
            '/system\(/i',
            '/exec\(/i',
            '/shell_exec/i',
            '/passthru/i',
            '/proc_open/i',
            '/popen/i',
        ];

        $allInput = $request->all();
        $inputString = json_encode($allInput);

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $inputString)) {
                \Log::warning('Suspicious input detected', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'input' => $allInput,
                    'pattern' => $pattern
                ]);

                abort(400, 'Invalid input detected');
            }
        }
    }
}
