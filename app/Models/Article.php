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
