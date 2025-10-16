<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'published',
        'published_at',
        'is_ai_generated',
        'scraped_content_id',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'is_ai_generated' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scrapedContent(): BelongsTo
    {
        return $this->belongsTo(ScrapedContent::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }
}
