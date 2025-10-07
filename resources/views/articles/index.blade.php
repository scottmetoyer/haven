<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Articles - Haven</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold">Haven</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2">Dashboard</a>
                            <a href="{{ route('admin.articles.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2">Manage Articles</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Latest Articles</h1>

                @if($articles->count() > 0)
                    <div class="space-y-6">
                        @foreach($articles as $article)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <h2 class="text-2xl font-semibold mb-2">
                                        <a href="{{ route('articles.show', $article->slug) }}" class="text-gray-900 hover:text-blue-600">
                                            {{ $article->title }}
                                        </a>
                                    </h2>
                                    @if($article->excerpt)
                                        <p class="text-gray-600 mb-4">{{ $article->excerpt }}</p>
                                    @else
                                        <div class="text-gray-700 mb-4 prose max-w-none">
                                            {!! Str::limit($article->content, 300) !!}
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-500">
                                        Published {{ $article->published_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $articles->links() }}
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-600">
                            No articles published yet.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
