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
}
