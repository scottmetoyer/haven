<?php

namespace App\Services;

use App\Models\AffiliateSite;
use App\Models\ScrapedContent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;

class AffiliateScraper
{
    /**
     * Scrape an affiliate site based on its configuration
     */
    public function scrape(AffiliateSite $site): array
    {
        if (!$site->is_enabled) {
            return [
                'success' => false,
                'message' => 'Site is disabled',
                'items_found' => 0,
            ];
        }

        try {
            $items = match ($site->scrape_strategy) {
                'rss' => $this->scrapeRss($site),
                'css' => $this->scrapeCss($site),
                'xpath' => $this->scrapeXpath($site),
                'custom' => $this->scrapeCustom($site),
                default => throw new \Exception('Invalid scrape strategy: ' . $site->scrape_strategy),
            };

            // Save scraped items
            $savedCount = $this->saveScrapedContent($site, $items);

            // Update last scraped timestamp
            $site->update(['last_scraped_at' => now()]);

            return [
                'success' => true,
                'message' => "Successfully scraped {$savedCount} new items",
                'items_found' => count($items),
                'items_saved' => $savedCount,
            ];

        } catch (\Exception $e) {
            Log::error("Failed to scrape affiliate site", [
                'site_id' => $site->id,
                'site_name' => $site->name,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Scraping failed: ' . $e->getMessage(),
                'items_found' => 0,
            ];
        }
    }

    /**
     * Scrape using RSS feed
     */
    protected function scrapeRss(AffiliateSite $site): array
    {
        $feedUrl = $site->rss_config['feed_url'] ?? null;

        if (empty($feedUrl)) {
            throw new \Exception('RSS feed URL not configured');
        }

        $response = Http::timeout(30)->get($feedUrl);

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch RSS feed: ' . $response->status());
        }

        $xml = simplexml_load_string($response->body());

        if ($xml === false) {
            throw new \Exception('Failed to parse RSS feed XML');
        }

        $items = [];

        // Handle RSS 2.0
        if (isset($xml->channel->item)) {
            foreach ($xml->channel->item as $item) {
                $items[] = [
                    'title' => (string) $item->title,
                    'url' => (string) ($item->link ?? $item->guid),
                    'discovered_at' => $this->parseDate((string) ($item->pubDate ?? null)),
                ];
            }
        }
        // Handle Atom
        elseif (isset($xml->entry)) {
            foreach ($xml->entry as $entry) {
                $items[] = [
                    'title' => (string) $entry->title,
                    'url' => (string) ($entry->link['href'] ?? $entry->id),
                    'discovered_at' => $this->parseDate((string) ($entry->published ?? $entry->updated ?? null)),
                ];
            }
        }

        return $items;
    }

    /**
     * Scrape using CSS selectors
     */
    protected function scrapeCss(AffiliateSite $site): array
    {
        $config = $site->css_config;

        if (empty($config['list_selector']) || empty($config['item_selector']) ||
            empty($config['title_selector']) || empty($config['url_selector'])) {
            throw new \Exception('Incomplete CSS configuration');
        }

        $response = Http::timeout(30)->get($site->base_url);

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch page: ' . $response->status());
        }

        $html = $response->body();

        // Use DOMDocument to parse HTML
        $doc = new DOMDocument();
        @$doc->loadHTML($html, LIBXML_NOERROR);
        $xpath = new DOMXPath($doc);

        // Convert CSS selectors to XPath
        $itemsXpath = $this->cssToXpath($config['item_selector']);
        $titleXpath = $this->cssToXpath($config['title_selector']);
        $urlXpath = $this->cssToXpath($config['url_selector']);
        $dateXpath = !empty($config['date_selector']) ? $this->cssToXpath($config['date_selector']) : null;

        $itemNodes = $xpath->query($itemsXpath);
        $items = [];

        foreach ($itemNodes as $itemNode) {
            $titleNode = $xpath->query($titleXpath, $itemNode)->item(0);
            $urlNode = $xpath->query($urlXpath, $itemNode)->item(0);

            $title = $titleNode ? trim($titleNode->textContent) : null;
            $url = $urlNode ? ($urlNode->getAttribute('href') ?: trim($urlNode->textContent)) : null;

            if ($title && $url) {
                $date = null;
                if ($dateXpath) {
                    $dateNode = $xpath->query($dateXpath, $itemNode)->item(0);
                    $date = $dateNode ? $this->parseDate($dateNode->getAttribute('datetime') ?: trim($dateNode->textContent)) : null;
                }

                $items[] = [
                    'title' => $title,
                    'url' => $this->normalizeUrl($url, $site->base_url),
                    'discovered_at' => $date,
                ];
            }
        }

        return $items;
    }

    /**
     * Scrape using XPath expressions
     */
    protected function scrapeXpath(AffiliateSite $site): array
    {
        $config = $site->xpath_config;

        if (empty($config['item_expression']) || empty($config['title_expression']) ||
            empty($config['url_expression'])) {
            throw new \Exception('Incomplete XPath configuration');
        }

        $response = Http::timeout(30)->get($site->base_url);

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch page: ' . $response->status());
        }

        $html = $response->body();

        $doc = new DOMDocument();
        @$doc->loadHTML($html, LIBXML_NOERROR);
        $xpath = new DOMXPath($doc);

        $itemNodes = $xpath->query($config['item_expression']);
        $items = [];

        foreach ($itemNodes as $itemNode) {
            $titleNode = $xpath->query($config['title_expression'], $itemNode)->item(0);
            $urlNode = $xpath->query($config['url_expression'], $itemNode)->item(0);

            $title = $titleNode ? trim($titleNode->nodeValue) : null;

            // Handle both attribute nodes (e.g., @href) and element nodes
            $url = null;
            if ($urlNode) {
                if ($urlNode instanceof \DOMAttr) {
                    $url = $urlNode->nodeValue;
                } elseif ($urlNode instanceof \DOMElement) {
                    $url = $urlNode->getAttribute('href') ?: trim($urlNode->textContent);
                } else {
                    $url = trim($urlNode->nodeValue);
                }
            }

            if ($title && $url) {
                $date = null;
                if (!empty($config['date_expression'])) {
                    $dateNode = $xpath->query($config['date_expression'], $itemNode)->item(0);
                    if ($dateNode) {
                        if ($dateNode instanceof \DOMAttr) {
                            $date = $this->parseDate($dateNode->nodeValue);
                        } elseif ($dateNode instanceof \DOMElement) {
                            $date = $this->parseDate($dateNode->getAttribute('datetime') ?: trim($dateNode->textContent));
                        } else {
                            $date = $this->parseDate(trim($dateNode->nodeValue));
                        }
                    }
                }

                $items[] = [
                    'title' => $title,
                    'url' => $this->normalizeUrl($url, $site->base_url),
                    'discovered_at' => $date,
                ];
            }
        }

        return $items;
    }

    /**
     * Scrape using custom scraper class
     */
    protected function scrapeCustom(AffiliateSite $site): array
    {
        $config = $site->custom_config;

        if (empty($config['scraper_class'])) {
            throw new \Exception('Custom scraper class not configured');
        }

        $scraperClass = $config['scraper_class'];

        if (!class_exists($scraperClass)) {
            throw new \Exception("Scraper class not found: {$scraperClass}");
        }

        $scraper = new $scraperClass();

        if (!method_exists($scraper, 'scrape')) {
            throw new \Exception("Scraper class must implement scrape() method");
        }

        return $scraper->scrape($site);
    }

    /**
     * Save scraped items to database (avoiding duplicates)
     */
    protected function saveScrapedContent(AffiliateSite $site, array $items): int
    {
        $savedCount = 0;

        foreach ($items as $item) {
            if (empty($item['url'])) {
                continue;
            }

            // Check if already exists
            $exists = ScrapedContent::where('affiliate_site_id', $site->id)
                ->where('content_url', $item['url'])
                ->exists();

            if (!$exists) {
                ScrapedContent::create([
                    'affiliate_site_id' => $site->id,
                    'content_url' => $item['url'],
                    'content_identifier' => md5($item['url']),
                    'title' => $item['title'] ?? null,
                    'discovered_at' => $item['discovered_at'] ?? now(),
                    'status' => 'pending',
                ]);

                $savedCount++;
            }
        }

        return $savedCount;
    }

    /**
     * Convert CSS selector to XPath (basic conversion)
     */
    protected function cssToXpath(string $selector): string
    {
        // Very basic CSS to XPath conversion
        // For production, consider using a library like symfony/css-selector

        $selector = trim($selector);

        // Handle simple cases
        if (str_starts_with($selector, '#')) {
            // ID selector: #id -> //*[@id='id']
            $id = substr($selector, 1);
            return "//*[@id='{$id}']";
        }

        if (str_starts_with($selector, '.')) {
            // Class selector: .class -> //*[contains(@class, 'class')]
            $class = substr($selector, 1);
            return "//*[contains(@class, '{$class}')]";
        }

        if (preg_match('/^([a-z]+)\.([a-z0-9-_]+)$/i', $selector, $matches)) {
            // Element.class: div.class -> //div[contains(@class, 'class')]
            return "//{$matches[1]}[contains(@class, '{$matches[2]}')]";
        }

        // Default: assume it's an element selector
        return "//{$selector}";
    }

    /**
     * Normalize relative URLs to absolute
     */
    protected function normalizeUrl(string $url, string $baseUrl): string
    {
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        $base = parse_url($baseUrl);
        $scheme = $base['scheme'] ?? 'https';
        $host = $base['host'] ?? '';

        if (str_starts_with($url, '//')) {
            return $scheme . ':' . $url;
        }

        if (str_starts_with($url, '/')) {
            return "{$scheme}://{$host}{$url}";
        }

        // Relative path
        $path = $base['path'] ?? '/';
        $path = rtrim(dirname($path), '/');
        return "{$scheme}://{$host}{$path}/{$url}";
    }

    /**
     * Parse date string to datetime or null
     */
    protected function parseDate(?string $dateStr): ?\DateTime
    {
        if (empty($dateStr)) {
            return null;
        }

        try {
            return new \DateTime($dateStr);
        } catch (\Exception $e) {
            return null;
        }
    }
}
