<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('adminpage/image/shtt_icon.jpg') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'SHTT') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <!-- Fonts -->

    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('adminpage/style.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <style>
        /* Tuỳ chỉnh NProgress */
        #nprogress .bar {
            background: #38b2ac !important; /* Tailwind teal-500 */
            height: 2px !important; /* Chiều cao của thanh progress bar */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
    </style>

</head>

<body>

    <div class="bg-base-100 drawer lg:drawer-open">
        <input id="drawer" type="checkbox" class="drawer-toggle">
        <div class="drawer-content bg-gray-50">
            <x-admin.header />
            {{ $slot }}
        </div>
        <!-- end navbar content -->
        <x-admin.sidebar />

    </div>
    <!-- end navbar -->

    @stack('bottom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            NProgress.start();
        });

        window.addEventListener('load', function() {
            NProgress.done();
        });
    </script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
    {{-- <script src="{{ asset('adminpage/scripts.js') }}"></script> --}}
</body>

</html>
