<x-web-layout>
    <x-slot name="title">
        Home Page - {{ config('app.name', 'Laravel') }}
    </x-slot>

    <!-- Nội dung của trang Home -->
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-gray-800">Home Page</h1>
        <p class="text-gray-600">This is the content of the home page.</p>
    </div>
</x-web-layout>
