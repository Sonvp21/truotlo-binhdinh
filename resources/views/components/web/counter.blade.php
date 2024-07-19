<div>
    <ul class="hidden space-y-1 rounded bg-black bg-opacity-80 p-4 text-xs text-gray-400 lg:block">
        <li>
            <div class="inline-flex items-center gap-2">
                {{ svg('heroicon-c-chart-bar', 'size-4 flex-none  animate-pulse text-green-700') }}
                <span class="flex-grow">Đang online: {{ $current }}</span>
            </div>
        </li>
        <li>
            <div class="inline-flex items-center gap-2">
                {{ svg('heroicon-o-clock', 'size-4 flex-none') }}
                <span class="flex-grow">Hôm nay: {{ $today }}</span>
            </div>
        </li>
        <li>
            <div class="inline-flex items-center gap-2">
                {{ svg('heroicon-o-calendar', 'flex-none size-4') }}
                <span class="flex-grow">Tháng này: {{ $month }}</span>
            </div>
        </li>
        <li>
            <div class="inline-flex items-center gap-2">
                {{ svg('heroicon-o-users', 'flex-none size-4') }}
                <span class="flex-grow">Tổng lượt truy cập: {{ $total }}</span>
            </div>
        </li>
    </ul>
</div>
