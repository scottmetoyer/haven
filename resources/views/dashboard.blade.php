<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ __("Welcome to your dashboard!") }}</h3>

                    <!-- Article Management Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <!-- Create Article -->
                        <a href="{{ route('admin.articles.create') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100 text-center">Create Article</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-300 text-center text-sm">Write and publish a new article</p>
                        </a>

                        <!-- View All Articles -->
                        <a href="{{ route('admin.articles.index') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100 text-center">View Articles</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-300 text-center text-sm">Browse and manage all articles</p>
                        </a>

                        <!-- Affiliate Sites -->
                        <a href="{{ route('admin.affiliate-sites.index') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100 text-center">Affiliate Sites</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-300 text-center text-sm">Manage affiliate sites to scrape</p>
                        </a>

                        <!-- Review Settings -->
                        <a href="{{ route('admin.review-settings.index') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100 text-center">Review Settings</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-300 text-center text-sm">Configure AI review generation</p>
                        </a>

                        <!-- Profile Settings -->
                        <a href="{{ route('profile.edit') }}" class="block p-6 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100 text-center">Profile Settings</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-300 text-center text-sm">Update your profile and settings</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
