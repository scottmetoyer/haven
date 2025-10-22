<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateSite;
use Illuminate\Http\Request;

class AffiliateSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $affiliateSites = AffiliateSite::latest()->paginate(15);
        return view('admin.affiliate-sites.index', compact('affiliateSites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.affiliate-sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'base_url' => 'required|url|max:255',
            'is_enabled' => 'boolean',
            'scrape_strategy' => 'required|in:rss,css,xpath,custom',
            'scrape_interval' => 'required|string',

            // RSS config
            'rss_feed_url' => 'nullable|url',

            // CSS config
            'css_list_selector' => 'nullable|string',
            'css_item_selector' => 'nullable|string',
            'css_title_selector' => 'nullable|string',
            'css_url_selector' => 'nullable|string',
            'css_date_selector' => 'nullable|string',

            // XPath config
            'xpath_list_expression' => 'nullable|string',
            'xpath_item_expression' => 'nullable|string',
            'xpath_title_expression' => 'nullable|string',
            'xpath_url_expression' => 'nullable|string',
            'xpath_date_expression' => 'nullable|string',

            // Custom config
            'custom_scraper_class' => 'nullable|string',
            'custom_config_json' => 'nullable|json',

            // Affiliate settings
            'affiliate_program_id' => 'nullable|string|max:255',
            'affiliate_tracking_code' => 'nullable|string|max:255',
        ]);

        $data = [
            'name' => $validated['name'],
            'base_url' => $validated['base_url'],
            'is_enabled' => $request->has('is_enabled'),
            'scrape_strategy' => $validated['scrape_strategy'],
            'scrape_interval' => $validated['scrape_interval'],
            'affiliate_program_id' => $validated['affiliate_program_id'] ?? null,
            'affiliate_tracking_code' => $validated['affiliate_tracking_code'] ?? null,
        ];

        // Build strategy-specific config
        switch ($validated['scrape_strategy']) {
            case 'rss':
                $data['rss_config'] = ['feed_url' => $validated['rss_feed_url']];
                break;
            case 'css':
                $data['css_config'] = [
                    'list_selector' => $validated['css_list_selector'],
                    'item_selector' => $validated['css_item_selector'],
                    'title_selector' => $validated['css_title_selector'],
                    'url_selector' => $validated['css_url_selector'],
                    'date_selector' => $validated['css_date_selector'] ?? null,
                ];
                break;
            case 'xpath':
                $data['xpath_config'] = [
                    'list_expression' => $validated['xpath_list_expression'],
                    'item_expression' => $validated['xpath_item_expression'],
                    'title_expression' => $validated['xpath_title_expression'],
                    'url_expression' => $validated['xpath_url_expression'],
                    'date_expression' => $validated['xpath_date_expression'] ?? null,
                ];
                break;
            case 'custom':
                $data['custom_config'] = [
                    'scraper_class' => $validated['custom_scraper_class'],
                    'options' => json_decode($validated['custom_config_json'] ?? '{}', true),
                ];
                break;
        }

        AffiliateSite::create($data);

        return redirect()->route('admin.affiliate-sites.index')
            ->with('success', 'Affiliate site created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AffiliateSite $affiliateSite)
    {
        $affiliateSite->load('scrapedContents');
        return view('admin.affiliate-sites.show', compact('affiliateSite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AffiliateSite $affiliateSite)
    {
        return view('admin.affiliate-sites.edit', compact('affiliateSite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AffiliateSite $affiliateSite)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'base_url' => 'required|url|max:255',
            'is_enabled' => 'boolean',
            'scrape_strategy' => 'required|in:rss,css,xpath,custom',
            'scrape_interval' => 'required|string',

            // RSS config
            'rss_feed_url' => 'nullable|url',

            // CSS config
            'css_list_selector' => 'nullable|string',
            'css_item_selector' => 'nullable|string',
            'css_title_selector' => 'nullable|string',
            'css_url_selector' => 'nullable|string',
            'css_date_selector' => 'nullable|string',

            // XPath config
            'xpath_list_expression' => 'nullable|string',
            'xpath_item_expression' => 'nullable|string',
            'xpath_title_expression' => 'nullable|string',
            'xpath_url_expression' => 'nullable|string',
            'xpath_date_expression' => 'nullable|string',

            // Custom config
            'custom_scraper_class' => 'nullable|string',
            'custom_config_json' => 'nullable|json',

            // Affiliate settings
            'affiliate_program_id' => 'nullable|string|max:255',
            'affiliate_tracking_code' => 'nullable|string|max:255',
        ]);

        $data = [
            'name' => $validated['name'],
            'base_url' => $validated['base_url'],
            'is_enabled' => $request->has('is_enabled'),
            'scrape_strategy' => $validated['scrape_strategy'],
            'scrape_interval' => $validated['scrape_interval'],
            'affiliate_program_id' => $validated['affiliate_program_id'] ?? null,
            'affiliate_tracking_code' => $validated['affiliate_tracking_code'] ?? null,
        ];

        // Build strategy-specific config
        switch ($validated['scrape_strategy']) {
            case 'rss':
                $data['rss_config'] = ['feed_url' => $validated['rss_feed_url']];
                break;
            case 'css':
                $data['css_config'] = [
                    'list_selector' => $validated['css_list_selector'],
                    'item_selector' => $validated['css_item_selector'],
                    'title_selector' => $validated['css_title_selector'],
                    'url_selector' => $validated['css_url_selector'],
                    'date_selector' => $validated['css_date_selector'] ?? null,
                ];
                break;
            case 'xpath':
                $data['xpath_config'] = [
                    'list_expression' => $validated['xpath_list_expression'],
                    'item_expression' => $validated['xpath_item_expression'],
                    'title_expression' => $validated['xpath_title_expression'],
                    'url_expression' => $validated['xpath_url_expression'],
                    'date_expression' => $validated['xpath_date_expression'] ?? null,
                ];
                break;
            case 'custom':
                $data['custom_config'] = [
                    'scraper_class' => $validated['custom_scraper_class'],
                    'options' => json_decode($validated['custom_config_json'] ?? '{}', true),
                ];
                break;
        }

        $affiliateSite->update($data);

        return redirect()->route('admin.affiliate-sites.index')
            ->with('success', 'Affiliate site updated successfully.');
    }

    /**
     * Manually trigger scraping for a specific site.
     */
    public function scrape(AffiliateSite $affiliateSite)
    {
        $scraper = app(\App\Services\AffiliateScraper::class);
        $result = $scraper->scrape($affiliateSite);

        if ($result['success']) {
            return redirect()->route('admin.affiliate-sites.index')
                ->with('success', $result['message']);
        } else {
            return redirect()->route('admin.affiliate-sites.index')
                ->with('error', $result['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AffiliateSite $affiliateSite)
    {
        $affiliateSite->delete();

        return redirect()->route('admin.affiliate-sites.index')
            ->with('success', 'Affiliate site deleted successfully.');
    }
}
