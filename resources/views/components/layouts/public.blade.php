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
        <x-public-header />

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <x-public-footer />
    </div>
</body>
</html>
