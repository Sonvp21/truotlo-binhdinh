<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    />
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    />
    <meta
        name="app-url"
        content="{{ url('/') }}"
    />
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/map/map.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 font-sans antialiased dark:bg-gray-900">
    <x-web.menu />
    <main class="relative h-full w-full">
        {{ $slot }}
    </main>
    @livewireScripts
    
</body>
</html>
