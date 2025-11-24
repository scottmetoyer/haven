<nav class="bg-white dark:bg-[#161615] border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ theme()->name() }}</a>
                    @if(theme()->tagline())
                        <span class="ml-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ theme()->tagline() }}</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] px-3 py-2">Dashboard</a>
                    <a href="{{ route('admin.articles.index') }}" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] px-3 py-2">Manage Articles</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
