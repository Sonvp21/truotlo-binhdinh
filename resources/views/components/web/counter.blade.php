<div>
    <ul class="hidden space-y-1 rounded text-white p-4 text-sm lg:block relative bg-cover bg-center"
        style="background-image: url('{{ asset('giao_dien/footer.png') }}'); width: 210px; height: 150px;">
        <!-- White overlay with adjusted opacity -->
        <div class="absolute inset-0 bg-white opacity-60 rounded"></div>
        <div class="relative z-10 text-black" > <!-- Ensure text is on top of the overlay -->
            <li class="m-2 mt-1" style="font-weight: 500">
                <div class="inline-flex items-center gap-2">
                    {{ svg('heroicon-c-chart-bar', 'size-4 flex-none animate-pulse text-green-700') }}
                    <span class="flex-grow">Đang online: {{ $current }}</span>
                </div>
            </li>
            <li class="m-2" style="font-weight: 500">
                <div class="inline-flex items-center gap-2">
                    {{ svg('heroicon-o-clock', 'size-4 flex-none') }}
                    <span class="flex-grow">Hôm nay: {{ $today }}</span>
                </div>
            </li>
            <li class="m-2" style="font-weight: 500">
                <div class="inline-flex items-center gap-2">
                    {{ svg('heroicon-o-calendar', 'flex-none size-4') }}
                    <span class="flex-grow">Tháng này: {{ $month }}</span>
                </div>
            </li>
            <li class="m-2" style="font-weight: 500">
                <div class="inline-flex items-center gap-2">
                    {{ svg('heroicon-o-users', 'flex-none size-4') }}
                    <span class="flex-grow">Tổng lượt truy cập: {{ $total }}</span>
                </div>
            </li>
        </div>
    </ul>

    <!-- Add this in your CSS file or <style> tag -->

</div>
