<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="app-url" content="{{ url('/') }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/map/map.js'])
</head>

<body class="min-h-screen bg-gray-100 font-sans antialiased dark:bg-gray-900">
    <x-web.header />
    <x-web.menu />
    <div class="relative mx-auto mt-4 flex h-full max-w-7xl flex-col gap-8 px-4 sm:px-6 md:flex-row lg:px-8">
            <x-web.aside />
        <main class="h-full w-full">
            {{ $slot }}
        </main>
    </div>
    <x-web.footer />

</body>

</html>
