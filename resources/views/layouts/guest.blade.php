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

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    />
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<<<<<<< HEAD
    <x-rich-text::styles
        theme="richtextlaravel"
        data-turbo-track="false"
    />
</head>
<body class="text-gray-900 font-sans antialiased">
    <div class="bg-gray-100 flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <div>
            <a href="/">
                <img
                    class="text-gray-500 h-20 w-auto fill-current"
                    src="{{ asset('files/images/logo.png') }}"
                    alt=""
                />
            </a>
        </div>

        <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
=======
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 dark:bg-gray-900">
        <div>
            <a href="/">
                <x-application-logo class="h-20 w-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-800">
>>>>>>> 683bbfeddd004eb38bb596b7f24d4996019df57a
            {{ $slot }}
        </div>
    </div>
</body>
</html>
