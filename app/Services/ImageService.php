<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Convert and compress an uploaded image or file to optimized WebP format
     * and save to public/images/{directory}.
     *
     * @param UploadedFile|string $file
     * @param string $directory (subfolder in public/images)
     * @param int $maxWidth
     * @param int $quality (0 - 100)
     * @return string (relative path for DB storage, e.g. "articles/xyz.webp")
     */
    public static function convertToWebp($file, string $directory = 'articles', int $maxWidth = 1200, int $quality = 80): ?string
    {
        $targetDir = public_path('images/' . $directory);
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true, true);
        }

        $filename = Str::random(24) . '.webp';
        $destinationPath = $targetDir . '/' . $filename;

        // 1. If it's an UploadedFile
        if ($file instanceof UploadedFile) {
            $sourcePath = $file->getRealPath();
            $mime = $file->getMimeType();
        } 
        // 2. If it's a local file path or URL
        elseif (is_string($file)) {
            if (filter_var($file, FILTER_VALIDATE_URL)) {
                $tempPath = sys_get_temp_dir() . '/' . Str::random(16);
                $content = @file_get_contents($file);
                if (!$content) {
                    return $file;
                }
                file_put_contents($tempPath, $content);
                $sourcePath = $tempPath;
                $mime = mime_content_type($tempPath);
            } elseif (File::exists($file)) {
                $sourcePath = $file;
                $mime = mime_content_type($file);
            } else {
                return null;
            }
        } else {
            return null;
        }

        // Create GD image resource based on mime type
        $image = null;
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = @imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = @imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                $image = @imagecreatefromwebp($sourcePath);
                break;
            case 'image/gif':
                $image = @imagecreatefromgif($sourcePath);
                break;
            case 'image/bmp':
                $image = @imagecreatefrombmp($sourcePath);
                break;
            default:
                if (function_exists('imagecreatefromstring')) {
                    $raw = @file_get_contents($sourcePath);
                    if ($raw) {
                        $image = @imagecreatefromstring($raw);
                    }
                }
                break;
        }

        if (!$image) {
            if (isset($tempPath) && File::exists($tempPath)) {
                @unlink($tempPath);
            }
            return is_string($file) ? $file : null;
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);

        // Resize if width exceeds maxWidth to keep file size ultra lightweight (30-60 KB)
        if ($origWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(($origHeight / $origWidth) * $newWidth);

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);

            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
            imagedestroy($image);
            $image = $resizedImage;
        } else {
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        // Save as WebP
        imagewebp($image, $destinationPath, $quality);
        imagedestroy($image);

        // Clean up temp file
        if (isset($tempPath) && File::exists($tempPath)) {
            @unlink($tempPath);
        }

        return $directory . '/' . $filename;
    }

    /**
     * Create a crisp default placeholder image in WebP format
     */
    public static function createDefaultPlaceholder(): void
    {
        $dir = public_path('images');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true, true);
        }

        $webpPath = $dir . '/default-news.webp';
        if (File::exists($webpPath)) {
            return;
        }

        $width = 800;
        $height = 500;
        $img = imagecreatetruecolor($width, $height);

        // Gradient dark navy background
        $bg = imagecolorallocate($img, 15, 23, 42); // #0f172a
        imagefill($img, 0, 0, $bg);

        // Accent header bar
        $accent = imagecolorallocate($img, 26, 86, 219); // #1a56db
        imagefilledrectangle($img, 0, 0, $width, 8, $accent);

        // Text
        $textColor = imagecolorallocate($img, 248, 250, 252);
        $subColor = imagecolorallocate($img, 148, 163, 184);

        imagestring($img, 5, (int)($width / 2 - 60), (int)($height / 2 - 20), "SmartNews", $textColor);
        imagestring($img, 3, (int)($width / 2 - 95), (int)($height / 2 + 10), "Portal Berita Terpercaya", $subColor);

        imagewebp($img, $webpPath, 85);
        imagedestroy($img);
    }
}
