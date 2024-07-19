<x-web-layout>
    <x-slot name="title">
        Giới thiệu - {{ config('app.name', 'Laravel') }}
    </x-slot>

    <style>
        .arrow-icon {
            transition: transform 0.3s ease;
        }
        .arrow-icon.up {
            transform: rotate(180deg);
        }
    </style>

    <!-- Nội dung của trang -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <form id="dateRangeForm" class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <label for="start_date" class="mr-2 text-gray-700">Từ ngày:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}" class="border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="flex items-center">
                    <label for="end_date" class="mr-2 text-gray-700">Đến ngày:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}" class="border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Áp dụng
                </button>
            </form>
        </div>
    
        <div class="text-center mb-8">
            <p class="text-lg font-semibold">Số lượng đường đã vẽ: <span id="lineCount" class="text-blue-600"></span></p>
        </div>

        <div class="mb-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div id="chartContainer" class="p-4">
                <canvas id="landslideChart"></canvas>
                <div id="legendContainerA" class="mt-4 overflow-y-auto max-h-40"></div>
                <div id="toggleLegendA" class="toggle-legend cursor-pointer mt-2 text-center">
                    <span class="arrow-icon text-gray-600 text-2xl">&#9660;</span>
                </div>
            </div>
        </div>

        <div class="mb-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div id="chartContainer" class="p-4">
                <canvas id="showChartB"></canvas>
                <div id="legendContainerB" class="mt-4 overflow-y-auto max-h-40"></div>
                <div id="toggleLegendB" class="toggle-legend cursor-pointer mt-2 text-center">
                    <span class="arrow-icon text-gray-600 text-2xl">&#9660;</span>
                </div>
            </div>
        </div>
        @include('web.chartLogic')
    </div>
</x-web-layout>