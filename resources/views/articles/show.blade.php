<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ theme()->description() }}">
    <title>{{ $article->title }} - {{ theme()->name() }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ theme()->favicon() }}">

    <!-- Theme Styles -->
    <x-theme-styles />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if(theme('analytics.google_analytics'))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ theme('analytics.google_analytics') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ theme('analytics.google_analytics') }}');
    </script>
    @endif
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <x-public-header />

        <main class="flex-grow">
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
        </main>

        <x-public-footer />
    </div>
</body>
</html>
