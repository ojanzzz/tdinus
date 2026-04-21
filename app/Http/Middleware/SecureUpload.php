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
        $mimeType = $file->getMimeType();
        $filename = $file->getClientOriginalName();
        
        // Skip deep scan for images - rely on MIME and extension validation
        if (str_starts_with($mimeType, 'image/')) {
            // Quick header check (first 1024 bytes) for non-PDF docs
            $content = file_get_contents($file->getPathname(), false, null, 0, 1024);
        } else {
            $content = file_get_contents($file->getPathname());
        }

        if (!$content) {
            return;
        }

        // More precise PHP check: must be followed by code, ignore in binary contexts
        if (preg_match('/<\?php\s*[^\s]/i', $content) || 
            preg_match('/<%\s*[^\s]/i', $content)) {
            Log::warning('Malicious PHP code detected in upload', [
                'ip' => $request->ip(),
                'filename' => $filename,
                'mime_type' => $mimeType
            ]);
            abort(400, 'Malicious content detected');
        }

        // Script tags only in text/html or if clearly executable
        if (preg_match('/<script\b[^>]*>/i', $content)) {
            Log::warning('Script tag detected in upload', [
                'ip' => $request->ip(),
                'filename' => $filename,
                'mime_type' => $mimeType
            ]);
            abort(400, 'Malicious content detected');
        }

        // Additional check for executable content in non-script files
        if (!str_starts_with($mimeType, 'image/') && 
            (preg_match('/(eval|exec|shell_exec|system|passthru)\s*\(/i', $content) ||
             preg_match('/base64_decode\s*\(/i', $content))) {
            Log::warning('Suspicious executable code detected', [
                'ip' => $request->ip(),
                'filename' => $filename,
                'mime_type' => $mimeType
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
            '/\.(php[0-9]*|phtml|pht|exe|bat|cmd|com|scr|pif|jar|sh|pl|asp|aspx|jsp|vb|wsf|cgi)$/i', // Executable extensions (allow image ext)
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $filename)) {
                return true;
            }
        }

        return false;
    }
}
