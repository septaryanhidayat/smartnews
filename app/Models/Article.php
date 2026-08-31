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
        // 1. If explicit ai_summary is provided in database
        if (!empty($this->ai_summary)) {
            $lines = preg_split('/\r\n|\r|\n/', trim($this->ai_summary));
            $points = [];
            foreach ($lines as $line) {
                $line = trim(ltrim(trim($line), '•-*0123456789.'));
                if (!empty($line)) {
                    $points[] = $line;
                }
            }
            if (count($points) > 0) {
                return $points;
            }
        }

        // 2. Intelligent extraction from article content and excerpt
        $points = [];

        // Parse HTML paragraphs
        $text = strip_tags(str_replace(['</p>', '</blockquote>', '</li>', '<br>', '<br/>'], "\n", $this->content));
        $paragraphs = array_filter(array_map('trim', explode("\n", $text)));

        foreach ($paragraphs as $para) {
            $sentences = preg_split('/(?<=[.!?])\s+/', $para, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($sentences as $s) {
                $s = stripslashes(trim($s));
                $s = trim($s, " \t\n\r\0\x0B\"'“”\\/`");
                if (mb_strlen($s) >= 30 && mb_strlen($s) <= 240) {
                    if (!in_array($s, $points)) {
                        $points[] = $s;
                        if (count($points) >= 3) {
                            break 2;
                        }
                    }
                }
            }
        }

        if (count($points) < 2 && !empty($this->excerpt)) {
            $points[] = stripslashes(trim($this->excerpt, " \t\n\r\0\x0B\"'“”\\/`"));
        }

        return count($points) > 0 ? $points : [
            $this->title,
            'Simak ulasan mendalam dan fakta selengkapnya pada liputan artikel berikut ini.'
        ];
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
