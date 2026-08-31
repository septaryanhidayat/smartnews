<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'ai_summary',
        'content',
        'image',
        'image_caption',
        'image_source',
        'media_type',
        'media_badge',
        'video_url',
        'video_id',
        'is_sticky',
        'is_slider',
        'views_count',
        'status',
        'published_at',
    ];

    protected $casts = [
        'is_sticky' => 'boolean',
        'is_slider' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
            if (empty($article->published_at)) {
                $article->published_at = now();
            }
            if (empty($article->excerpt) && !empty($article->content)) {
                $article->excerpt = Str::limit(strip_tags($article->content), 180);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->orderBy('created_at', 'desc');
    }

    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return max(1, $minutes);
    }

    /**
     * AI Summary Bullet Points
     */
    public function getAiSummaryPointsAttribute()
    {
        $cleanBullet = function ($text) {
            if (empty($text)) return '';
            $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $text = strip_tags(str_replace(['<br>', '<br/>', '</p>'], ' ', $text));
            $text = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $text);
            $text = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $text);
            $text = preg_replace('/^\s*(?:[A-Za-z\s]+,\s*)?SmartNews\s*[-–—]\s*/iu', '', $text);
            $text = preg_replace('/^\s*(?:[A-Z\s]+,\s*[A-Z\s]+\s*[-–—]\s*)/u', '', $text);
            $text = preg_replace('/\(\*\)\s*&nbsp;/u', '', $text);
            $text = preg_replace('/\(\*\)/u', '', $text);
            $text = str_replace(['&nbsp;', '&#160;', '\u00a0'], ' ', $text);
            $text = ltrim(trim($text), "•-*0123456789. \t\n\r");
            $text = trim($text, " \t\n\r\0\x0B\"'“”\\/`");
            return $text;
        };

        $isValidSentence = function ($s) {
            if (mb_strlen($s) < 25 || mb_strlen($s) > 280) return false;
            // Reject any string that looks like code
            if (preg_match('/(?:<script|function\s*\(|var\s+|const\s+|window\.|document\.|style=|class=|[{}\[\];<=>])/i', $s)) {
                return false;
            }
            return true;
        };

        // 1. If explicit ai_summary is provided in database
        if (!empty($this->ai_summary)) {
            $lines = preg_split('/\r\n|\r|\n/', trim($this->ai_summary));
            $points = [];
            foreach ($lines as $line) {
                $cleaned = $cleanBullet($line);
                if ($isValidSentence($cleaned)) {
                    $points[] = $cleaned;
                }
            }
            if (count($points) > 0) {
                return $points;
            }
        }

        // 2. Intelligent extraction from article content and excerpt
        $points = [];
        $text = strip_tags(str_replace(['</p>', '</blockquote>', '</li>', '<br>', '<br/>'], "\n", $this->content));
        $paragraphs = array_filter(array_map('trim', explode("\n", $text)));

        foreach ($paragraphs as $para) {
            $sentences = preg_split('/(?<=[.!?])\s+/', $para, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($sentences as $s) {
                $cleaned = $cleanBullet($s);
                if ($isValidSentence($cleaned) && !in_array($cleaned, $points)) {
                    $points[] = $cleaned;
                    if (count($points) >= 3) {
                        break 2;
                    }
                }
            }
        }

        if (count($points) < 2 && !empty($this->excerpt)) {
            $cleanedExcerpt = $cleanBullet($this->excerpt);
            if ($isValidSentence($cleanedExcerpt)) {
                $points[] = $cleanedExcerpt;
            }
        }

        if (count($points) === 0) {
            $cleanedTitle = $cleanBullet($this->title);
            $points[] = $cleanedTitle ?: $this->title;
            $points[] = app()->getLocale() === 'en'
                ? 'Read the full coverage and in-depth report in the article below.'
                : 'Simak ulasan mendalam dan fakta selengkapnya pada liputan artikel berikut ini.';
        }

        return $points;
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('images/default-news.webp');
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        if (Str::startsWith($this->image, 'articles/')) {
            return asset('images/' . $this->image);
        }

        if (Str::startsWith($this->image, 'images/')) {
            return asset($this->image);
        }

        if (file_exists(public_path('images/' . $this->image))) {
            return asset('images/' . $this->image);
        }

        if (file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        return asset('images/default-news.webp');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }

    /**
     * AI SEO Analysis & Score Calculator (0 - 100)
     */
    public function getSeoAnalysisAttribute(): array
    {
        $score = 0;
        $checklist = [];
        $suggestions = [];

        // 1. Title Analysis (Max 20 pts)
        $titleLength = mb_strlen(trim($this->title ?? ''));
        if ($titleLength >= 40 && $titleLength <= 80) {
            $score += 20;
            $checklist[] = ['status' => 'pass', 'label' => "Panjang Judul Optimal ($titleLength karakter)", 'detail' => 'Panjang judul ideal untuk search engine Google (40-80 karakter).'];
        } elseif ($titleLength >= 25 && $titleLength < 40) {
            $score += 12;
            $checklist[] = ['status' => 'warn', 'label' => "Panjang Judul Kurang Panjang ($titleLength karakter)", 'detail' => 'Disarankan minimal 40 karakter agar lebih informatif di Google Search.'];
            $suggestions[] = 'Perpanjang judul dengan menambahkan kata kunci subjek/lokasi (target 40-75 karakter).';
        } elseif ($titleLength > 80) {
            $score += 10;
            $checklist[] = ['status' => 'warn', 'label' => "Judul Agak Panjang ($titleLength karakter)", 'detail' => 'Judul lebih dari 80 karakter berisiko terpotong pada cuplikan SERP Google.'];
            $suggestions[] = 'Persingkat judul agar inti topik terbaca jelas di hasil pencarian.';
        } else {
            $score += 5;
            $checklist[] = ['status' => 'fail', 'label' => "Judul Terlalu Pendek ($titleLength karakter)", 'detail' => 'Judul terlalu pendek menurunkan peluang klik (CTR).'];
            $suggestions[] = 'Buat judul yang lebih spesifik dan memuat kata kunci utama.';
        }

        // 2. Content Length & Depth (Max 25 pts)
        $plainContent = strip_tags($this->content ?? '');
        $wordCount = str_word_count($plainContent);
        if ($wordCount >= 400) {
            $score += 25;
            $checklist[] = ['status' => 'pass', 'label' => "Kedalaman Artikel Luar Biasa ($wordCount kata)", 'detail' => 'Artikel sangat komprehensif, disukai algoritma Google Helpful Content.'];
        } elseif ($wordCount >= 200) {
            $score += 18;
            $checklist[] = ['status' => 'pass', 'label' => "Panjang Konten Memadai ($wordCount kata)", 'detail' => 'Panjang artikel memenuhi standar jurnalisme digital (min 200 kata).'];
        } elseif ($wordCount >= 100) {
            $score += 10;
            $checklist[] = ['status' => 'warn', 'label' => "Konten Agak Singkat ($wordCount kata)", 'detail' => 'Artikel masih tergolong ringkas.'];
            $suggestions[] = 'Tambahkan kutipan narasumber, kronologi, atau latar belakang untuk memperkaya artikel (>200 kata).';
        } else {
            $score += 4;
            $checklist[] = ['status' => 'fail', 'label' => "Konten Terlalu Tipis ($wordCount kata)", 'detail' => 'Artikel tipis berisiko dianggap low quality oleh search engine.'];
            $suggestions[] = 'Lengkapi liputan berita dengan data pendukung minimal 200-300 kata.';
        }

        // 3. AI Summary & Bullet Points (Max 20 pts)
        $aiPoints = $this->ai_summary_points;
        if (count($aiPoints) >= 3) {
            $score += 20;
            $checklist[] = ['status' => 'pass', 'label' => "Ringkasan Cerdas AI Aktif (" . count($aiPoints) . " poin)", 'detail' => 'Mendukung cuplikan Google AI Overviews & SGE Rich Snippet.'];
        } elseif (count($aiPoints) >= 1) {
            $score += 12;
            $checklist[] = ['status' => 'pass', 'label' => "Ringkasan Cerdas AI (" . count($aiPoints) . " poin)", 'detail' => 'Ringkasan tersedia.'];
        } else {
            $checklist[] = ['status' => 'warn', 'label' => "Belum Ada Ringkasan AI Khusus", 'detail' => 'Sistem otomatis mengekstrak ringkasan dari konten.'];
            $suggestions[] = 'Lengkapi field Ringkasan AI untuk mengontrol cuplikan cerdas yang tampil di hasil pencarian.';
        }

        // 4. Excerpt / Meta Description (Max 15 pts)
        $excerptLen = mb_strlen(trim($this->excerpt ?? ''));
        if ($excerptLen >= 70 && $excerptLen <= 200) {
            $score += 15;
            $checklist[] = ['status' => 'pass', 'label' => "Meta Excerpt Optimal ($excerptLen karakter)", 'detail' => 'Deskripsi ideal untuk cuplikan SERP Google & Social Share.'];
        } elseif ($excerptLen > 0) {
            $score += 8;
            $checklist[] = ['status' => 'warn', 'label' => "Meta Excerpt Perlu Disesuaikan ($excerptLen karakter)", 'detail' => 'Panjang ideal deskripsi adalah 80-160 karakter.'];
            $suggestions[] = 'Sesuaikan ringkasan excerpt menjadi 1-2 kalimat padat (80-160 karakter).';
        } else {
            $checklist[] = ['status' => 'fail', 'label' => "Ringkasan Excerpt Kosong", 'detail' => 'Ringkasan artikel penting untuk metadata preview.'];
            $suggestions[] = 'Tuliskan 1-2 kalimat ringkasan tajam pada field Ringkasan/Excerpt.';
        }

        // 5. Featured Image & Media (Max 10 pts)
        if (!empty($this->image)) {
            $score += 10;
            $checklist[] = ['status' => 'pass', 'label' => "Gambar Utama & Visual Lengkap", 'detail' => 'Gambar utama meningkatkan CTR hingga 45% di Google Discover.'];
        } else {
            $checklist[] = ['status' => 'fail', 'label' => "Belum Ada Gambar Utama", 'detail' => 'Artikel tanpa foto memiliki performa SEO & social share yang rendah.'];
            $suggestions[] = 'Unggah gambar utama berkualitas tinggi yang relevan dengan topik berita.';
        }

        // 6. Category & Tags Keyword Taxonomy (Max 10 pts)
        $tagCount = $this->tags ? $this->tags->count() : 0;
        if ($this->category_id && $tagCount >= 2) {
            $score += 10;
            $checklist[] = ['status' => 'pass', 'label' => "Rubrik & {$tagCount} Tags Terkait", 'detail' => 'Struktur taksonomi kata kunci dan internal link sangat baik.'];
        } elseif ($this->category_id && $tagCount >= 1) {
            $score += 7;
            $checklist[] = ['status' => 'pass', 'label' => "Rubrik & {$tagCount} Tag", 'detail' => 'Taksonomi cukup baik.'];
            $suggestions[] = 'Tambahkan 2-3 tag topik spesifik untuk memperluas pencarian terkait.';
        } else {
            $score += 3;
            $checklist[] = ['status' => 'warn', 'label' => "Belum Ada Tag Kata Kunci", 'detail' => 'Tag membantu pengelompokan topik pencarian.'];
            $suggestions[] = 'Pilih atau tambahkan minimal 2-4 tag topik yang relevan.';
        }

        $score = min(100, max(15, $score));

        // Grade calculation
        if ($score >= 88) {
            $grade = 'A+';
            $gradeText = 'Sangat Baik (Optimal)';
            $badgeColor = '#059669'; // Emerald
            $badgeBg = '#d1fae5';
        } elseif ($score >= 75) {
            $grade = 'A';
            $gradeText = 'Baik';
            $badgeColor = '#0284c7'; // Sky blue
            $badgeBg = '#e0f2fe';
        } elseif ($score >= 60) {
            $grade = 'B';
            $gradeText = 'Cukup';
            $badgeColor = '#d97706'; // Amber
            $badgeBg = '#fef3c7';
        } else {
            $grade = 'C';
            $gradeText = 'Perlu Optimasi';
            $badgeColor = '#dc2626'; // Red
            $badgeBg = '#fee2e2';
        }

        if (empty($suggestions)) {
            $suggestions[] = 'Kualitas SEO artikel ini sudah sangat prima dan siap bersaing di halaman 1 Google!';
        }

        return [
            'score' => $score,
            'grade' => $grade,
            'grade_text' => $gradeText,
            'badge_color' => $badgeColor,
            'badge_bg' => $badgeBg,
            'word_count' => $wordCount,
            'title_length' => $titleLength,
            'checklist' => $checklist,
            'suggestions' => $suggestions,
        ];
    }
}
