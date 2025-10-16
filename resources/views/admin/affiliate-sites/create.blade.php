<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Add Affiliate Site') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.affiliate-sites.store') }}" id="affiliate-site-form">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>

                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Site Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="base_url" class="block text-gray-700 text-sm font-bold mb-2">Base URL *</label>
                                <input type="url" name="base_url" id="base_url" value="{{ old('base_url') }}" placeholder="https://example.com"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('base_url') border-red-500 @enderror">
                                @error('base_url')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_enabled" value="1" {{ old('is_enabled', true) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Enable scraping</span>
                                </label>
                            </div>
                        </div>

                        <!-- Scrape Configuration -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Scraping Configuration</h3>

                            <div class="mb-4">
                                <label for="scrape_strategy" class="block text-gray-700 text-sm font-bold mb-2">Scrape Strategy *</label>
                                <select name="scrape_strategy" id="scrape_strategy"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('scrape_strategy') border-red-500 @enderror">
                                    <option value="">Select a strategy...</option>
                                    <option value="rss" {{ old('scrape_strategy') === 'rss' ? 'selected' : '' }}>RSS Feed</option>
                                    <option value="css" {{ old('scrape_strategy') === 'css' ? 'selected' : '' }}>CSS Selectors</option>
                                    <option value="xpath" {{ old('scrape_strategy') === 'xpath' ? 'selected' : '' }}>XPath Expressions</option>
                                    <option value="custom" {{ old('scrape_strategy') === 'custom' ? 'selected' : '' }}>Custom Scraper</option>
                                </select>
                                @error('scrape_strategy')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="scrape_interval" class="block text-gray-700 text-sm font-bold mb-2">Scrape Interval *</label>
                                <input type="text" name="scrape_interval" id="scrape_interval" value="{{ old('scrape_interval', 'daily') }}" placeholder="e.g., daily, hourly, 6h, 30m"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('scrape_interval') border-red-500 @enderror">
                                <p class="text-gray-500 text-xs mt-1">Examples: daily, hourly, 6h, 30m</p>
                                @error('scrape_interval')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- RSS Strategy Config -->
                        <div id="rss-config" class="mb-6 strategy-config hidden">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">RSS Feed Configuration</h4>

                            <div class="mb-4">
                                <label for="rss_feed_url" class="block text-gray-700 text-sm font-bold mb-2">RSS Feed URL *</label>
                                <input type="url" name="rss_feed_url" id="rss_feed_url" value="{{ old('rss_feed_url') }}" placeholder="https://example.com/feed.xml"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('rss_feed_url') border-red-500 @enderror">
                                @error('rss_feed_url')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- CSS Strategy Config -->
                        <div id="css-config" class="mb-6 strategy-config hidden">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">CSS Selector Configuration</h4>

                            <div class="mb-4">
                                <label for="css_list_selector" class="block text-gray-700 text-sm font-bold mb-2">List Container Selector *</label>
                                <input type="text" name="css_list_selector" id="css_list_selector" value="{{ old('css_list_selector') }}" placeholder="e.g., .article-list, #posts"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('css_list_selector') border-red-500 @enderror">
                                @error('css_list_selector')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="css_item_selector" class="block text-gray-700 text-sm font-bold mb-2">Individual Item Selector *</label>
                                <input type="text" name="css_item_selector" id="css_item_selector" value="{{ old('css_item_selector') }}" placeholder="e.g., .article-item, .post"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('css_item_selector') border-red-500 @enderror">
                                @error('css_item_selector')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="css_title_selector" class="block text-gray-700 text-sm font-bold mb-2">Title Selector *</label>
                                <input type="text" name="css_title_selector" id="css_title_selector" value="{{ old('css_title_selector') }}" placeholder="e.g., h2.title, .article-title"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('css_title_selector') border-red-500 @enderror">
                                @error('css_title_selector')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="css_url_selector" class="block text-gray-700 text-sm font-bold mb-2">URL Selector *</label>
                                <input type="text" name="css_url_selector" id="css_url_selector" value="{{ old('css_url_selector') }}" placeholder="e.g., a.permalink, .article-link"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('css_url_selector') border-red-500 @enderror">
                                @error('css_url_selector')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="css_date_selector" class="block text-gray-700 text-sm font-bold mb-2">Date Selector (Optional)</label>
                                <input type="text" name="css_date_selector" id="css_date_selector" value="{{ old('css_date_selector') }}" placeholder="e.g., time.published, .post-date"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('css_date_selector') border-red-500 @enderror">
                                @error('css_date_selector')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- XPath Strategy Config -->
                        <div id="xpath-config" class="mb-6 strategy-config hidden">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">XPath Expression Configuration</h4>

                            <div class="mb-4">
                                <label for="xpath_list_expression" class="block text-gray-700 text-sm font-bold mb-2">List Container XPath *</label>
                                <input type="text" name="xpath_list_expression" id="xpath_list_expression" value="{{ old('xpath_list_expression') }}" placeholder="e.g., //div[@class='article-list']"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('xpath_list_expression') border-red-500 @enderror">
                                @error('xpath_list_expression')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="xpath_item_expression" class="block text-gray-700 text-sm font-bold mb-2">Individual Item XPath *</label>
                                <input type="text" name="xpath_item_expression" id="xpath_item_expression" value="{{ old('xpath_item_expression') }}" placeholder="e.g., //article"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('xpath_item_expression') border-red-500 @enderror">
                                @error('xpath_item_expression')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="xpath_title_expression" class="block text-gray-700 text-sm font-bold mb-2">Title XPath *</label>
                                <input type="text" name="xpath_title_expression" id="xpath_title_expression" value="{{ old('xpath_title_expression') }}" placeholder="e.g., //h2[@class='title']/text()"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('xpath_title_expression') border-red-500 @enderror">
                                @error('xpath_title_expression')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="xpath_url_expression" class="block text-gray-700 text-sm font-bold mb-2">URL XPath *</label>
                                <input type="text" name="xpath_url_expression" id="xpath_url_expression" value="{{ old('xpath_url_expression') }}" placeholder="e.g., //a[@class='permalink']/@href"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('xpath_url_expression') border-red-500 @enderror">
                                @error('xpath_url_expression')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="xpath_date_expression" class="block text-gray-700 text-sm font-bold mb-2">Date XPath (Optional)</label>
                                <input type="text" name="xpath_date_expression" id="xpath_date_expression" value="{{ old('xpath_date_expression') }}" placeholder="e.g., //time/@datetime"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('xpath_date_expression') border-red-500 @enderror">
                                @error('xpath_date_expression')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Custom Strategy Config -->
                        <div id="custom-config" class="mb-6 strategy-config hidden">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">Custom Scraper Configuration</h4>

                            <div class="mb-4">
                                <label for="custom_scraper_class" class="block text-gray-700 text-sm font-bold mb-2">Scraper Class Name *</label>
                                <input type="text" name="custom_scraper_class" id="custom_scraper_class" value="{{ old('custom_scraper_class') }}" placeholder="e.g., App\Scrapers\CustomSiteScraper"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('custom_scraper_class') border-red-500 @enderror">
                                @error('custom_scraper_class')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="custom_config_json" class="block text-gray-700 text-sm font-bold mb-2">Custom Configuration (JSON)</label>
                                <textarea name="custom_config_json" id="custom_config_json" rows="6" placeholder='{"key": "value"}'
                                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline font-mono text-sm @error('custom_config_json') border-red-500 @enderror">{{ old('custom_config_json', '{}') }}</textarea>
                                @error('custom_config_json')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Affiliate Settings -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Affiliate Settings (Optional)</h3>

                            <div class="mb-4">
                                <label for="affiliate_program_id" class="block text-gray-700 text-sm font-bold mb-2">Affiliate Program ID</label>
                                <input type="text" name="affiliate_program_id" id="affiliate_program_id" value="{{ old('affiliate_program_id') }}" placeholder="e.g., amazon-associates-123"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('affiliate_program_id') border-red-500 @enderror">
                                @error('affiliate_program_id')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="affiliate_tracking_code" class="block text-gray-700 text-sm font-bold mb-2">Affiliate Tracking Code</label>
                                <input type="text" name="affiliate_tracking_code" id="affiliate_tracking_code" value="{{ old('affiliate_tracking_code') }}" placeholder="e.g., tag=yoursite-20"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('affiliate_tracking_code') border-red-500 @enderror">
                                @error('affiliate_tracking_code')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Add Affiliate Site
                            </button>
                            <a href="{{ route('admin.affiliate-sites.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide strategy-specific configuration sections
        document.addEventListener('DOMContentLoaded', function() {
            const strategySelect = document.getElementById('scrape_strategy');
            const strategyConfigs = document.querySelectorAll('.strategy-config');

            function updateStrategyConfig() {
                const selectedStrategy = strategySelect.value;

                // Hide all strategy configs
                strategyConfigs.forEach(config => {
                    config.classList.add('hidden');
                });

                // Show the selected strategy config
                if (selectedStrategy) {
                    const configDiv = document.getElementById(selectedStrategy + '-config');
                    if (configDiv) {
                        configDiv.classList.remove('hidden');
                    }
                }
            }

            strategySelect.addEventListener('change', updateStrategyConfig);

            // Initialize on page load
            updateStrategyConfig();
        });
    </script>
</x-app-layout>
