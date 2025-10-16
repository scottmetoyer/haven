<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScrapedContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_site_id',
        'content_url',
        'content_identifier',
        'title',
        'discovered_at',
        'processed_at',
        'status',
        'error_message',
        'article_id',
    ];

    protected $casts = [
        'discovered_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function affiliateSite(): BelongsTo
    {
        return $this->belongsTo(AffiliateSite::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
