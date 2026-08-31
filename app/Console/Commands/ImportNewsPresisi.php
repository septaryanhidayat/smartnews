<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportNewsPresisi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:newspresisi {--download-images : Download all images locally to public/uploads/articles}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all real news articles and featured media from https://newspresisi.id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('================================================================');
        $this->info('Starting Real News Import from https://newspresisi.id ...');
        $this->info('================================================================');

        $downloadImages = $this->option('download-images');
        $uploadDir = public_path('uploads/articles');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        $adminUser = User::where('role', 'admin')->first() ?? User::first();

        $page = 1;
        $allPosts = [];

        while (true) {
            $this->line("Fetching posts page {$page} from newspresisi.id...");
            try {
                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36')
                    ->get("https://newspresisi.id/wp-json/wp/v2/posts?per_page=50&page={$page}&_embed=1");

                if ($response->failed()) {
                    break;
                }

                $posts = $response->json();
                if (empty($posts) || !is_array($posts)) {
                    break;
                }

                $allPosts = array_merge($allPosts, $posts);

                if (count($posts) < 50) {
                    break;
                }

                $page++;
            } catch (\Exception $e) {
                $this->error("Error fetching page {$page}: " . $e->getMessage());
                break;
            }
        }

        $total = count($allPosts);
        $this->info("Total posts successfully retrieved: {$total}");

        if ($total === 0) {
            $this->warn('No posts found to import.');
            return 0;
        }

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $imported = 0;

        foreach ($allPosts as $post) {
            $title = html_entity_decode($post['title']['rendered'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $title = trim(strip_tags($title));
            if (empty($title)) {
                $bar->advance();
                continue;
            }

            $slug = $post['slug'] ?? Str::slug($title);
            $content = $post['content']['rendered'] ?? '';
            $excerpt = strip_tags(html_entity_decode($post['excerpt']['rendered'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $excerpt = Str::limit(trim($excerpt), 280);

            if (empty($excerpt)) {
                $plainContent = strip_tags($content);
                $excerpt = Str::limit(trim(preg_replace('/\s+/', ' ', $plainContent)), 200);
            }

            $publishedAt = isset($post['date']) ? date('Y-m-d H:i:s', strtotime($post['date'])) : now();

            // 1. Featured Image
            $remoteImageUrl = $post['_embedded']['wp:featuredmedia'][0]['source_url'] ?? null;
            $imagePath = $remoteImageUrl;

            if ($downloadImages && $remoteImageUrl) {
                try {
                    $ext = pathinfo(parse_url($remoteImageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'webp';
                    $localFileName = $slug . '-' . time() . '.' . $ext;
                    $localFilePath = $uploadDir . DIRECTORY_SEPARATOR . $localFileName;

                    if (!File::exists($localFilePath)) {
                        $imgData = @file_get_contents($remoteImageUrl);
                        if ($imgData !== false) {
                            File::put($localFilePath, $imgData);
                            $imagePath = 'uploads/articles/' . $localFileName;
                        }
                    } else {
                        $imagePath = 'uploads/articles/' . $localFileName;
                    }
                } catch (\Exception $ex) {
                    $imagePath = $remoteImageUrl;
                }
            }

            // 2. Category Extraction & Mapping
            $categoryName = 'Nasional';
            if (isset($post['_embedded']['wp:term'])) {
                foreach ($post['_embedded']['wp:term'] as $taxGroup) {
                    foreach ($taxGroup as $term) {
                        if (($term['taxonomy'] ?? '') === 'category' && !in_array(strtolower($term['name']), ['uncategorized', 'tak berkategori'])) {
                            $categoryName = html_entity_decode($term['name'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            break 2;
                        }
                    }
                }
            }

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                [
                    'name' => $categoryName,
                    'color' => '#cf2e2e',
                    'order' => 10,
                ]
            );

            // Clean all newspresisi mentions to SmartNews
            $searchPatterns = [
                '/https?:\/\/(?:www\.)?newspresisi\.id\/?/i' => 'https://smartnews.berandadigital.net/',
                '/<a[^>]*href=["\'][^"\']*newspresisi\.id[^"\']*["\'][^>]*>(.*?)<\/a>/i' => '$1',
                '/\bNEWSPRESISI\.ID\b/i' => 'SmartNews',
                '/\bNewspresisi\.id\b/i' => 'SmartNews',
                '/\bnewspresisi\.id\b/i' => 'smartnews.berandadigital.net',
                '/\bNEWSPRESISI\b/i' => 'SmartNews',
                '/\bNewspresisi\b/i' => 'SmartNews',
                '/\bnewspresisi\b/i' => 'smartnews',
            ];
            foreach ($searchPatterns as $pattern => $replacement) {
                $title = preg_replace($pattern, $replacement, $title);
                $excerpt = preg_replace($pattern, $replacement, $excerpt);
                $content = preg_replace($pattern, $replacement, $content);
            }

            // 3. AI Summary Generation (Extract 3 key smart bullet points)
            $plainText = strip_tags($content);
            $sentences = preg_split('/(?<=[.?!])\s+(?=[A-Z0-9])/u', $plainText, -1, PREG_SPLIT_NO_EMPTY);
            $summaryBullets = [];
            foreach ($sentences as $s) {
                $cleanSentence = trim(preg_replace('/\s+/', ' ', $s));
                if (strlen($cleanSentence) >= 40 && strlen($cleanSentence) <= 220) {
                    $summaryBullets[] = $cleanSentence;
                }
                if (count($summaryBullets) >= 3) {
                    break;
                }
            }
            if (empty($summaryBullets)) {
                $summaryBullets = [
                    Str::limit($excerpt, 140),
                    'Informasi terkini dan terpercaya dilaporkan langsung oleh tim jurnalis dari lokasi peristiwa.',
                    'Simak liputan mendalam dan perkembangan berita selengkapnya di bawah ini.'
                ];
            }
            $aiSummary = implode("\n", $summaryBullets);
            foreach ($searchPatterns as $pattern => $replacement) {
                $aiSummary = preg_replace($pattern, $replacement, $aiSummary);
            }

            // 4. Save Article
            $article = Article::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $adminUser->id ?? 1,
                    'category_id' => $category->id,
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'ai_summary' => $aiSummary,
                    'content' => $content,
                    'image' => $imagePath,
                    'image_caption' => 'Liputan dokumentasi peristiwa resmi SmartNews',
                    'image_source' => 'SmartNews',
                    'media_type' => 'standard',
                    'status' => 'published',
                    'published_at' => $publishedAt,
                    'views_count' => rand(850, 6500),
                ]
            );

            // 5. Tags Extraction & Sync
            $tagIds = [];
            if (isset($post['_embedded']['wp:term'])) {
                foreach ($post['_embedded']['wp:term'] as $taxGroup) {
                    foreach ($taxGroup as $term) {
                        if (($term['taxonomy'] ?? '') === 'post_tag') {
                            $tagName = html_entity_decode($term['name'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            $tag = Tag::firstOrCreate(
                                ['slug' => Str::slug($tagName)],
                                ['name' => $tagName]
                            );
                            $tagIds[] = $tag->id;
                        }
                    }
                }
            }

            if (!empty($tagIds)) {
                $article->tags()->sync($tagIds);
            }

            $imported++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("================================================================");
        $this->info("IMPORT COMPLETED: {$imported} real news articles successfully imported and published!");
        $this->info("================================================================");

        return 0;
    }
}
