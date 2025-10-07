<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription ?? theme()->description() }}">
    <title>{{ $title ?? theme()->name() }}</title>

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
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <x-public-footer />
    </div>
</body>
</html>
