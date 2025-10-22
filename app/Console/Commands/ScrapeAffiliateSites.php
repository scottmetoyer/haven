<?php

namespace App\Console\Commands;

use App\Jobs\ScrapeAffiliateSite;
use App\Models\AffiliateSite;
use App\Services\AffiliateScraper;
use Illuminate\Console\Command;

class ScrapeAffiliateSites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'affiliate:scrape
                            {site? : The ID of a specific affiliate site to scrape}
                            {--sync : Run synchronously instead of dispatching jobs}
                            {--enabled-only : Only scrape enabled sites (default)}
                            {--all : Scrape all sites regardless of enabled status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape affiliate sites for new content';

    /**
     * Execute the console command.
     */
    public function handle(AffiliateScraper $scraper): int
    {
        $siteId = $this->argument('site');
        $sync = $this->option('sync');
        $scrapeAll = $this->option('all');

        // Get sites to scrape
        if ($siteId) {
            $sites = AffiliateSite::where('id', $siteId)->get();

            if ($sites->isEmpty()) {
                $this->error("Affiliate site with ID {$siteId} not found.");
                return 1;
            }
        } else {
            $query = AffiliateSite::query();

            if (!$scrapeAll) {
                $query->where('is_enabled', true);
            }

            $sites = $query->get();
        }

        if ($sites->isEmpty()) {
            $this->warn('No affiliate sites to scrape.');
            return 0;
        }

        $this->info("Found {$sites->count()} site(s) to scrape.");

        foreach ($sites as $site) {
            $this->info("Processing: {$site->name} (ID: {$site->id})");

            if ($sync) {
                // Run synchronously for testing/debugging
                $result = $scraper->scrape($site);

                if ($result['success']) {
                    $this->line("  ✓ Success: {$result['message']}");
                    $this->line("    Items found: {$result['items_found']}");
                    $this->line("    Items saved: {$result['items_saved']}");
                } else {
                    $this->error("  ✗ Failed: {$result['message']}");
                }
            } else {
                // Dispatch job to queue
                ScrapeAffiliateSite::dispatch($site->id);
                $this->line("  → Job dispatched to queue");
            }
        }

        if (!$sync) {
            $this->newLine();
            $this->info('Scrape jobs have been dispatched. Run the queue worker to process them:');
            $this->line('  php artisan queue:work');
        }

        return 0;
    }
}
