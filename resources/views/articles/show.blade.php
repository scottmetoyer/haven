<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - Haven</title>
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
                            <a href="{{ route('register') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <a href="{{ route('articles.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Articles</a>
                </div>

                <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>

                        <div class="text-sm text-gray-500 mb-8">
                            Published {{ $article->published_at->format('F j, Y') }}
                        </div>

                        <div class="prose max-w-none">
                            {!! nl2br(e($article->content)) !!}
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</body>
</html>
