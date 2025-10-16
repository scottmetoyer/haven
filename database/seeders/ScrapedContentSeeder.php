<?php

namespace Database\Seeders;

use App\Models\AffiliateSite;
use App\Models\ScrapedContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScrapedContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, ensure we have at least one affiliate site
        $affiliateSite = AffiliateSite::first();

        if (!$affiliateSite) {
            $affiliateSite = AffiliateSite::create([
                'name' => 'Example Tech Blog',
                'base_url' => 'https://example-tech-blog.com',
                'is_enabled' => true,
                'scrape_strategy' => 'rss',
                'scrape_interval' => 60,
                'rss_config' => [
                    'feed_url' => 'https://example-tech-blog.com/feed',
                ],
            ]);
        }

        // Create sample scraped content with different statuses
        $scrapedContents = [
            [
                'title' => 'Top 10 Gaming Laptops for 2025',
                'content_url' => 'https://example-tech-blog.com/top-10-gaming-laptops-2025',
                'content_identifier' => 'gaming-laptops-2025',
                'status' => 'pending',
                'discovered_at' => now()->subDays(2),
            ],
            [
                'title' => 'Best Mechanical Keyboards Under $100',
                'content_url' => 'https://example-tech-blog.com/best-mechanical-keyboards-under-100',
                'content_identifier' => 'mechanical-keyboards-budget',
                'status' => 'pending',
                'discovered_at' => now()->subDays(1),
            ],
            [
                'title' => '5 Must-Have Productivity Apps in 2025',
                'content_url' => 'https://example-tech-blog.com/productivity-apps-2025',
                'content_identifier' => 'productivity-apps',
                'status' => 'processing',
                'discovered_at' => now()->subHours(12),
            ],
            [
                'title' => 'Ultimate Guide to Home Office Setup',
                'content_url' => 'https://example-tech-blog.com/home-office-setup-guide',
                'content_identifier' => 'home-office-guide',
                'status' => 'pending',
                'discovered_at' => now()->subHours(6),
            ],
            [
                'title' => 'Wireless Headphones Comparison 2025',
                'content_url' => 'https://example-tech-blog.com/wireless-headphones-comparison',
                'content_identifier' => 'wireless-headphones',
                'status' => 'completed',
                'discovered_at' => now()->subDays(5),
                'processed_at' => now()->subDays(4),
            ],
            [
                'title' => 'Smart Home Devices You Need Right Now',
                'content_url' => 'https://example-tech-blog.com/smart-home-devices',
                'content_identifier' => 'smart-home',
                'status' => 'failed',
                'discovered_at' => now()->subDays(3),
                'error_message' => 'Failed to extract content: Page structure changed',
            ],
            [
                'title' => 'Best Budget Smartphones in 2025',
                'content_url' => 'https://example-tech-blog.com/budget-smartphones-2025',
                'content_identifier' => 'budget-smartphones',
                'status' => 'pending',
                'discovered_at' => now()->subHours(3),
            ],
            [
                'title' => 'Standing Desk Reviews and Recommendations',
                'content_url' => 'https://example-tech-blog.com/standing-desk-reviews',
                'content_identifier' => 'standing-desks',
                'status' => 'pending',
                'discovered_at' => now()->subHours(1),
            ],
        ];

        foreach ($scrapedContents as $content) {
            ScrapedContent::create(array_merge([
                'affiliate_site_id' => $affiliateSite->id,
            ], $content));
        }
    }
}
