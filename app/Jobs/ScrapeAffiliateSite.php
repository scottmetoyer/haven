<?php

namespace App\Jobs;

use App\Models\AffiliateSite;
use App\Services\AffiliateScraper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ScrapeAffiliateSite implements ShouldQueue
{
    use Queueable;

    public $timeout = 120; // 2 minutes timeout
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $affiliateSiteId
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(AffiliateScraper $scraper): void
    {
        $site = AffiliateSite::find($this->affiliateSiteId);

        if (!$site) {
            Log::warning("Affiliate site not found", ['site_id' => $this->affiliateSiteId]);
            return;
        }

        Log::info("Starting scrape for affiliate site", [
            'site_id' => $site->id,
            'site_name' => $site->name,
        ]);

        $result = $scraper->scrape($site);

        if ($result['success']) {
            Log::info("Scrape completed successfully", [
                'site_id' => $site->id,
                'site_name' => $site->name,
                'items_found' => $result['items_found'],
                'items_saved' => $result['items_saved'],
            ]);
        } else {
            Log::error("Scrape failed", [
                'site_id' => $site->id,
                'site_name' => $site->name,
                'message' => $result['message'],
            ]);
        }
    }
}
