<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AI Review Generation Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.review-settings.update') }}">
                        @csrf

                        <!-- RunPod API Configuration -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">RunPod API Configuration</h3>

                            <div class="mb-4">
                                <label for="runpod_api_endpoint" class="block text-gray-700 text-sm font-bold mb-2">API Endpoint</label>
                                <input type="url" name="runpod_api_endpoint" id="runpod_api_endpoint"
                                       value="{{ old('runpod_api_endpoint', $settings['runpod_api_endpoint'] ?? '') }}"
                                       placeholder="https://api.runpod.io/v2/your-endpoint"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('runpod_api_endpoint') border-red-500 @enderror">
                                <p class="text-gray-500 text-xs mt-1">The RunPod serverless endpoint URL for AI generation</p>
                                @error('runpod_api_endpoint')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="runpod_api_key" class="block text-gray-700 text-sm font-bold mb-2">API Key</label>
                                <input type="password" name="runpod_api_key" id="runpod_api_key"
                                       value="{{ old('runpod_api_key', $settings['runpod_api_key'] ?? '') }}"
                                       placeholder="Enter your RunPod API key"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('runpod_api_key') border-red-500 @enderror">
                                <p class="text-gray-500 text-xs mt-1">Your RunPod API authentication key (kept secure)</p>
                                @error('runpod_api_key')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="runpod_timeout" class="block text-gray-700 text-sm font-bold mb-2">API Timeout (seconds)</label>
                                <input type="number" name="runpod_timeout" id="runpod_timeout" min="1"
                                       value="{{ old('runpod_timeout', $settings['runpod_timeout'] ?? 120) }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('runpod_timeout') border-red-500 @enderror">
                                <p class="text-gray-500 text-xs mt-1">Maximum time to wait for API response (default: 120 seconds)</p>
                                @error('runpod_timeout')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Review Generation Settings -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Generation Settings</h3>

                            <div class="mb-4">
                                <label for="default_review_prompt_template" class="block text-gray-700 text-sm font-bold mb-2">Default Prompt Template</label>
                                <textarea name="default_review_prompt_template" id="default_review_prompt_template" rows="8"
                                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline font-mono text-sm @error('default_review_prompt_template') border-red-500 @enderror">{{ old('default_review_prompt_template', $settings['default_review_prompt_template'] ?? 'Write a comprehensive review article based on the following source content:\n\nTitle: {title}\nURL: {url}\nContent: {content}\n\nPlease create an engaging, SEO-optimized review that:\n- Summarizes the key points\n- Provides valuable insights\n- Maintains a professional tone\n- Includes relevant keywords\n- Is approximately 500-800 words') }}</textarea>
                                <p class="text-gray-500 text-xs mt-1">Template for AI-generated reviews. Use {title}, {url}, and {content} as placeholders.</p>
                                @error('default_review_prompt_template')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="auto_publish_enabled" value="1"
                                           {{ old('auto_publish_enabled', $settings['auto_publish_enabled'] ?? false) ? 'checked' : '' }}
                                           class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Auto-publish generated reviews</span>
                                </label>
                                <p class="text-gray-500 text-xs mt-1 ml-7">Automatically publish AI-generated articles without manual review</p>
                            </div>

                            <div class="mb-4">
                                <label for="rate_limit_per_hour" class="block text-gray-700 text-sm font-bold mb-2">Rate Limit (per hour)</label>
                                <input type="number" name="rate_limit_per_hour" id="rate_limit_per_hour" min="1"
                                       value="{{ old('rate_limit_per_hour', $settings['rate_limit_per_hour'] ?? 10) }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('rate_limit_per_hour') border-red-500 @enderror">
                                <p class="text-gray-500 text-xs mt-1">Maximum number of AI-generated reviews per hour (default: 10)</p>
                                @error('rate_limit_per_hour')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between border-t pt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Save Settings
                            </button>
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">Back to Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">How AI Review Generation Works</h3>
                <ul class="list-disc list-inside text-blue-800 text-sm space-y-2">
                    <li>The system scrapes content from configured affiliate sites based on their scrape intervals</li>
                    <li>New content is stored and can be automatically sent to RunPod for AI-powered review generation</li>
                    <li>The AI uses your custom prompt template to create SEO-optimized review articles</li>
                    <li>Reviews can be auto-published or held for manual review before publishing</li>
                    <li>Rate limiting prevents excessive API usage and costs</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
