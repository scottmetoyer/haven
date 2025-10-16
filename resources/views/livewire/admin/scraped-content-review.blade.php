<div>
    <div class="py-4">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Scraped Content Review</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Select content items and generate articles using AI</p>
            </div>
            <div>
                @if(count($selectedContent) > 0)
                    <span class="mr-4 text-sm text-gray-700 dark:text-gray-300">{{ count($selectedContent) }} selected</span>
                    <button wire:click="openModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Generate Article
                    </button>
                @else
                    <button disabled class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed">
                        Generate Article
                    </button>
                @endif
            </div>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-12">
                                <input type="checkbox" class="rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Source</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Discovered</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">URL</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($scrapedContents as $content)
                            <tr class="{{ in_array($content->id, $selectedContent) ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input
                                        type="checkbox"
                                        wire:click="toggleSelection({{ $content->id }})"
                                        {{ in_array($content->id, $selectedContent) ? 'checked' : '' }}
                                        class="rounded"
                                    >
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $content->title ?? 'No title' }}
                                    </div>
                                    @if($content->content_identifier)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $content->content_identifier }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $content->affiliateSite->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $content->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $content->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $content->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $content->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($content->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $content->discovered_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ $content->content_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm truncate block max-w-xs">
                                        {{ Str::limit($content->content_url, 50) }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No scraped content available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t">
                {{ $scrapedContents->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                    Generate Article from Selected Content
                                </h3>

                                <div class="mt-4">
                                    <h4 class="font-semibold text-sm text-gray-700 mb-2">Selected Content ({{ count($selectedScrapedContents) }}):</h4>
                                    <div class="bg-gray-50 rounded p-3 max-h-48 overflow-y-auto">
                                        <ul class="space-y-2">
                                            @foreach($selectedScrapedContents as $content)
                                                <li class="text-sm">
                                                    <span class="font-medium">{{ $content->title ?? 'No title' }}</span>
                                                    <span class="text-gray-500">- {{ $content->affiliateSite->name ?? 'N/A' }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="aiPrompt" class="block text-sm font-medium text-gray-700 mb-2">
                                        AI Prompt Instructions
                                    </label>
                                    <textarea
                                        id="aiPrompt"
                                        wire:model="aiPrompt"
                                        rows="6"
                                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Example: Write a comparison article highlighting the key differences between these products. Focus on features, pricing, and user reviews. Make it engaging and SEO-friendly with around 1000 words."
                                    ></textarea>
                                    @error('aiPrompt')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-4 bg-blue-50 border border-blue-200 rounded p-3">
                                    <div class="text-sm text-blue-700">
                                        <strong>Note:</strong> Article generation is processed asynchronously. The job will be queued and processed in the background. Check the articles list to see when it's complete.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            wire:click="generateArticle"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 hover:bg-blue-700 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Queue Article Generation
                        </button>
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
