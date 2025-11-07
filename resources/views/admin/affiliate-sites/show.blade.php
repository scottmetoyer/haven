<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Affiliate Site Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $affiliateSite->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $affiliateSite->base_url }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.affiliate-sites.edit', $affiliateSite) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <form action="{{ route('admin.affiliate-sites.scrape', $affiliateSite) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Scrape Now
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Status</h4>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $affiliateSite->is_enabled ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                    {{ $affiliateSite->is_enabled ? 'Enabled' : 'Disabled' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Scrape Strategy</h4>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    {{ strtoupper($affiliateSite->scrape_strategy) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Scrape Interval</h4>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $affiliateSite->scrape_interval }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase">Last Scraped</h4>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $affiliateSite->last_scraped_at?->format('M j, Y H:i') ?? 'Never' }}</p>
                        </div>
                    </div>

                    @if($affiliateSite->affiliate_program_id || $affiliateSite->affiliate_tracking_code)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-6">
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase mb-3">Affiliate Settings</h4>
                            <div class="grid grid-cols-2 gap-4">
                                @if($affiliateSite->affiliate_program_id)
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Program ID</h5>
                                        <p class="text-gray-900 dark:text-white">{{ $affiliateSite->affiliate_program_id }}</p>
                                    </div>
                                @endif
                                @if($affiliateSite->affiliate_tracking_code)
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Tracking Code</h5>
                                        <p class="text-gray-900 dark:text-white">{{ $affiliateSite->affiliate_tracking_code }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Scraped Content -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Scraped Content ({{ $affiliateSite->scrapedContents->count() }} items)
                    </h3>

                    @if($affiliateSite->scrapedContents->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">URL</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Discovered</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($affiliateSite->scrapedContents->take(20) as $content)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $content->title ?? 'No title' }}
                                                </div>
                                                @if($content->articles->isEmpty())
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                        NEW
                                                    </span>
                                                @endif
                                            </div>
                                            @if($content->content_identifier)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $content->content_identifier }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <a href="{{ $content->content_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                    {{ Str::limit($content->content_url, 50) }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $content->discovered_at?->format('M j, Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($affiliateSite->scrapedContents->count() > 20)
                            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                Showing first 20 of {{ $affiliateSite->scrapedContents->count() }} items.
                            </p>
                        @endif
                    @else
                        <p class="text-gray-600 dark:text-gray-400">No content scraped yet.</p>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.affiliate-sites.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                    ← Back to Affiliate Sites
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
