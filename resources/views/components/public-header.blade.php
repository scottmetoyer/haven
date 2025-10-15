<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold">{{ theme()->name() }}</a>
                    @if(theme()->tagline())
                        <span class="ml-2 text-sm text-gray-500">{{ theme()->tagline() }}</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2">Dashboard</a>
                    <a href="{{ route('admin.articles.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2">Manage Articles</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
