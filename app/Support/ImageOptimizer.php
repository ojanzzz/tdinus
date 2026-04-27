<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageOptimizer
{
    private const MAX_WIDTH = 1600;
    private const MAX_HEIGHT = 1600;
    private const WEBP_QUALITY = 80;

    public static function storeUploadedImage(UploadedFile $file, string $directory = 'uploads'): string
    {
        $directory = trim($directory, '/');
        $targetDirectory = public_path($directory);

        if (! File::isDirectory($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true, true);
        }

        $basename = (string) Str::uuid();
        $webpRelativePath = $directory . '/' . $basename . '.webp';
        $webpAbsolutePath = public_path($webpRelativePath);

        if (self::createWebpImage($file->getRealPath(), $webpAbsolutePath)) {
            return '/' . str_replace('\\', '/', $webpRelativePath);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
        $extension = preg_replace('/[^a-z0-9]+/i', '', $extension) ?: 'jpg';
        $fallbackRelativePath = $directory . '/' . $basename . '.' . $extension;

        $file->move($targetDirectory, basename($fallbackRelativePath));

        return '/' . str_replace('\\', '/', $fallbackRelativePath);
    }

    public static function deletePublicImage(?string $publicPath): void
    {
        if (! $publicPath) {
            return;
        }

        $paths = [public_path(ltrim($publicPath, '/'))];
        $webpVariant = self::webpVariantPath($publicPath);

        if ($webpVariant && $webpVariant !== $publicPath) {
            $paths[] = public_path(ltrim($webpVariant, '/'));
        }

        foreach (array_unique($paths) as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }

    public static function webpVariantPath(?string $publicPath): ?string
    {
        if (! $publicPath) {
            return null;
        }

        $resolvedPath = parse_url($publicPath, PHP_URL_PATH) ?: $publicPath;

        if (preg_match('/\.webp$/i', $resolvedPath)) {
            return $resolvedPath;
        }

        if (! preg_match('/\.(jpe?g|png)$/i', $resolvedPath)) {
            return null;
        }

        return preg_replace('/\.(jpe?g|png)$/i', '.webp', $resolvedPath);
    }

    public static function createWebpVariant(string $absolutePath, bool $overwrite = false): bool
    {
        if (! File::exists($absolutePath)) {
            return false;
        }

        if (preg_match('/\.webp$/i', $absolutePath)) {
            return false;
        }

        $targetPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $absolutePath);

        if (! $targetPath) {
            return false;
        }

        if (! $overwrite && File::exists($targetPath) && filemtime($targetPath) >= filemtime($absolutePath)) {
            return false;
        }

        return self::createWebpImage($absolutePath, $targetPath);
    }

    private static function createWebpImage(string $sourcePath, string $targetPath): bool
    {
        if (! File::exists($sourcePath)) {
            return false;
        }

        $imageInfo = @getimagesize($sourcePath);

        if (! $imageInfo) {
            return false;
        }

        [$width, $height, $type] = $imageInfo;
        $sourceImage = self::createImageResource($sourcePath, $type);

        if (! $sourceImage) {
            return false;
        }

        $sourceImage = self::applyOrientation($sourcePath, $type, $sourceImage);
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        [$targetWidth, $targetHeight] = self::constrainDimensions($width, $height);
        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        if (! $canvas) {
            imagedestroy($sourceImage);

            return false;
        }

        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $transparent);

        imagecopyresampled(
            $canvas,
            $sourceImage,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            imagesx($sourceImage),
            imagesy($sourceImage)
        );

        $directory = dirname($targetPath);
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        $saved = imagewebp($canvas, $targetPath, self::WEBP_QUALITY);

        imagedestroy($canvas);
        imagedestroy($sourceImage);

        return (bool) $saved;
    }

    private static function createImageResource(string $sourcePath, int $type): mixed
    {
        return match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => @imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : false,
            default => false,
        };
    }

    private static function applyOrientation(string $sourcePath, int $type, mixed $image): mixed
    {
        if ($type !== IMAGETYPE_JPEG || ! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($sourcePath);
        $orientation = (int) ($exif['Orientation'] ?? 1);

        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => $image,
        };

        if ($rotated !== $image && is_object($rotated)) {
            imagedestroy($image);
        }

        return $rotated ?: $image;
    }

    private static function constrainDimensions(int $width, int $height): array
    {
        if ($width <= self::MAX_WIDTH && $height <= self::MAX_HEIGHT) {
            return [$width, $height];
        }

        $ratio = min(self::MAX_WIDTH / max($width, 1), self::MAX_HEIGHT / max($height, 1));

        return [
            max(1, (int) round($width * $ratio)),
            max(1, (int) round($height * $ratio)),
        ];
    }
}
