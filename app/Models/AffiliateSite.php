<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AffiliateSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_url',
        'is_enabled',
        'scrape_strategy',
        'scrape_interval',
        'last_scraped_at',
        'rss_config',
        'css_config',
        'xpath_config',
        'custom_config',
        'affiliate_program_id',
        'affiliate_tracking_code',
        'link_insertion_rules',
        'latest_content_date',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'last_scraped_at' => 'datetime',
        'latest_content_date' => 'datetime',
        'rss_config' => 'array',
        'css_config' => 'array',
        'xpath_config' => 'array',
        'custom_config' => 'array',
        'link_insertion_rules' => 'array',
    ];

    public function scrapedContents(): HasMany
    {
        return $this->hasMany(ScrapedContent::class);
    }
}
