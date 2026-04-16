<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecureUpload
{
    /**
     * Allowed MIME types for uploads.
     */
    protected array $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'application/pdf',
        'text/plain',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    /**
     * Maximum file size in bytes (5MB).
     */
    protected int $maxFileSize = 5242880;

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasFile('image') || $request->hasFile('file') || $request->hasFile('attachment')) {
            $files = $request->allFiles();

            foreach ($files as $fileBag) {
                if (is_array($fileBag)) {
                    foreach ($fileBag as $file) {
                        $this->validateFile($file, $request);
                    }
                } else {
                    $this->validateFile($fileBag, $request);
                }
            }
        }

        return $next($request);
    }

    /**
     * Validate a single uploaded file.
     */
    protected function validateFile($file, Request $request): void
    {
        // Check if file is valid
        if (!$file->isValid()) {
            Log::warning('Invalid file upload attempt', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'error' => $file->getErrorMessage()
            ]);
            abort(400, 'Invalid file upload');
        }

        // Check file size
        if ($file->getSize() > $this->maxFileSize) {
            Log::warning('File too large upload attempt', [
                'ip' => $request->ip(),
                'size' => $file->getSize(),
                'max_size' => $this->maxFileSize
            ]);
            abort(400, 'File size too large');
        }

        // Check MIME type
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $this->allowedMimeTypes)) {
            Log::warning('Disallowed file type upload attempt', [
                'ip' => $request->ip(),
                'mime_type' => $mimeType,
                'filename' => $file->getClientOriginalName()
            ]);
            abort(400, 'File type not allowed');
        }

        // Check for malicious file content
        $this->checkForMaliciousContent($file, $request);

        // Check filename for suspicious patterns
        $filename = $file->getClientOriginalName();
        if ($this->hasSuspiciousFilename($filename)) {
            Log::warning('Suspicious filename upload attempt', [
                'ip' => $request->ip(),
                'filename' => $filename
            ]);
            abort(400, 'Invalid filename');
        }
    }

    /**
     * Check for malicious content in uploaded files.
     */
    protected function checkForMaliciousContent($file, Request $request): void
    {
        $content = file_get_contents($file->getPathname());

        // Check for PHP code
        if (preg_match('/<\?php/i', $content) || preg_match('/<%/i', $content)) {
            Log::warning('Malicious PHP code detected in upload', [
                'ip' => $request->ip(),
                'filename' => $file->getClientOriginalName()
            ]);
            abort(400, 'Malicious content detected');
        }

        // Check for script tags
        if (preg_match('/<script/i', $content)) {
            Log::warning('Script tag detected in upload', [
                'ip' => $request->ip(),
                'filename' => $file->getClientOriginalName()
            ]);
            abort(400, 'Malicious content detected');
        }
    }

    /**
     * Check for suspicious filename patterns.
     */
    protected function hasSuspiciousFilename(string $filename): bool
    {
        $suspiciousPatterns = [
            '/\.\./',           // Directory traversal
            '/\//',             // Path separators
            '/\\\\/',           // Backslashes
            '/^\./',            // Hidden files
            '/[<>:*?"|]/',      // Invalid characters
            '/\.(php|exe|bat|cmd|com|scr|pif|jar|js|vb|wsf)$/i', // Executable extensions
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $filename)) {
                return true;
            }
        }

        return false;
    }
}
