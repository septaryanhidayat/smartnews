<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\SiteSetting;
use App\Services\ImageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateOptimizedArticleImages extends Command
{
    protected $signature = 'smartnews:generate-images';
    protected $description = 'Generate local optimized WebP images for all articles';

    public function handle()
    {
        $this->info('Generating default WebP placeholder...');
        ImageService::createDefaultPlaceholder();

        $storageDir = storage_path('app/public/articles');
        $publicDir = public_path('images/articles');
        if (!File::exists($storageDir)) {
            File::makeDirectory($storageDir, 0755, true, true);
        }
        if (!File::exists($publicDir)) {
            File::makeDirectory($publicDir, 0755, true, true);
        }

        // Color palettes for different news categories
        $categoryColors = [
            'nasional' => ['bg1' => [207, 46, 46], 'bg2' => [153, 27, 27], 'tag' => 'NASIONAL'],
            'internasional' => ['bg1' => [26, 86, 219], 'bg2' => [30, 58, 138], 'tag' => 'INTERNASIONAL'],
            'politik' => ['bg1' => [5, 150, 105], 'bg2' => [6, 78, 59], 'tag' => 'POLITIK'],
            'ekonomi' => ['bg1' => [217, 119, 6], 'bg2' => [146, 64, 14], 'tag' => 'EKONOMI'],
            'olahraga' => ['bg1' => [124, 58, 237], 'bg2' => [91, 33, 182], 'tag' => 'OLAHRAGA'],
            'teknologi' => ['bg1' => [2, 132, 199], 'bg2' => [12, 74, 110], 'tag' => 'TEKNOLOGI'],
            'otomotif' => ['bg1' => [220, 38, 38], 'bg2' => [127, 29, 29], 'tag' => 'OTOMOTIF'],
            'kesehatan' => ['bg1' => [16, 185, 129], 'bg2' => [4, 120, 87], 'tag' => 'KESEHATAN'],
            'travel' => ['bg1' => [245, 158, 11], 'bg2' => [180, 83, 9], 'tag' => 'TRAVEL'],
        ];

        $articles = Article::with('category')->get();

        foreach ($articles as $art) {
            $catSlug = $art->category->slug ?? 'nasional';
            $colors = $categoryColors[$catSlug] ?? $categoryColors['nasional'];

            $filename = 'art_' . $art->id . '_' . Str::slug($art->slug) . '.webp';
            $filePath = $storageDir . '/' . $filename;

            // Generate crisp high-res 1200x800 WebP image
            $width = 1200;
            $height = 800;
            $img = imagecreatetruecolor($width, $height);

            // Dark gradient base
            for ($y = 0; $y < $height; $y++) {
                $ratio = $y / $height;
                $r = (int)($colors['bg1'][0] * (1 - $ratio * 0.5) + $colors['bg2'][0] * ($ratio * 0.5));
                $g = (int)($colors['bg1'][1] * (1 - $ratio * 0.5) + $colors['bg2'][1] * ($ratio * 0.5));
                $b = (int)($colors['bg1'][2] * (1 - $ratio * 0.5) + $colors['bg2'][2] * ($ratio * 0.5));
                $lineColor = imagecolorallocate($img, max(0, min(255, $r)), max(0, min(255, $g)), max(0, min(255, $b)));
                imageline($img, 0, $y, $width, $y, $lineColor);
            }

            // Geometric tech overlay pattern
            $overlayColor = imagecolorallocatealpha($img, 255, 255, 255, 115);
            for ($i = 0; $i < $width; $i += 60) {
                imageline($img, $i, 0, $i + 200, $height, $overlayColor);
            }

            // Dark vignette bottom
            $darkBottom = imagecolorallocatealpha($img, 10, 15, 30, 40);
            imagefilledrectangle($img, 0, (int)($height * 0.55), $width, $height, $darkBottom);

            // Category Pill in image
            $pillBg = imagecolorallocate($img, 255, 255, 255);
            $pillText = imagecolorallocate($img, $colors['bg1'][0], $colors['bg1'][1], $colors['bg1'][2]);
            imagefilledrectangle($img, 60, 60, 240, 105, $pillBg);
            imagestring($img, 5, 80, 75, $colors['tag'], $pillText);

            // SmartNews Watermark in top right
            $white = imagecolorallocate($img, 255, 255, 255);
            $mutedWhite = imagecolorallocatealpha($img, 255, 255, 255, 30);
            imagestring($img, 5, $width - 200, 75, "SmartNews HD", $white);

            // Short title text in lower section
            $shortTitle = Str::limit($art->title, 65);
            imagestring($img, 5, 60, $height - 120, $shortTitle, $white);
            imagestring($img, 4, 60, $height - 80, "Liputan Eksklusif Redaksi SmartNews", $mutedWhite);

            $publicFilePath = $publicDir . '/' . $filename;

            // Save as optimized WebP (Quality 85, size ~18-35 KB)
            imagewebp($img, $filePath, 85);
            imagewebp($img, $publicFilePath, 85);
            imagedestroy($img);

            // Update database image path
            $art->image = 'articles/' . $filename;
            $art->save();

            $this->info("Generated WebP for article: {$art->title} (" . round(filesize($filePath) / 1024) . " KB)");
        }

        // Update Site Settings to SmartNews
        SiteSetting::set('site_name', 'SmartNews');
        SiteSetting::set('site_tagline', 'Portal Berita Terpercaya & Cerdas');
        SiteSetting::set('site_description', 'Portal berita Indonesia terpercaya, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.');

        $this->info('All article images have been generated as optimized WebP files!');
        return 0;
    }
}
