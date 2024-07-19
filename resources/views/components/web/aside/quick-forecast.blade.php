<div>
    <div>
        <div class="h-auto rounded border border-sky-600 bg-sky-100 shadow">
            <h2 class="sticky top-12 flex h-12 items-center bg-sky-600 px-4 text-sm font-bold uppercase shadow">Dự báo lúc:
                {{ now()->format('H:i') }} ngày {{ now()->format('d/m') }}</h2>
            <div class="p-4 text-sm">
                <ul class="">
                    <li class="flex items-center gap-2 py-1.5">
                        {{ svg('heroicon-s-bolt', 'size-3 text-yellow-500') }}
                        <div class="flex w-full justify-between">
                            <span>Số điểm mưa lớn (>=30mm)</span>
                            <span class="flex size-5 items-center justify-center rounded-full bg-white">0</span>
                        </div>
                    </li>
                    <li class="flex items-center gap-2 py-1.5">
                        {{ svg('heroicon-s-bolt', 'size-3 text-yellow-500') }}
                        <div class="flex w-full justify-between">
                            <span>Số điểm nguy cơ sạt lở</span>
                            <span class="flex size-5 items-center justify-center rounded-full bg-white">0</span>
                        </div>
                    </li>
                    <li class="flex items-center gap-2 py-1.5">
                        {{ svg('heroicon-s-bolt', 'size-3 text-yellow-500') }}
                        <div class="flex w-full justify-between">
                            <span>Số công trình có nguy cơ bị thiệt hại</span>
                            <span class="flex size-5 items-center justify-center rounded-full bg-white">0</span>
                        </div>
                    </li>
                    <li class="flex items-center gap-2 py-1.5">
                        {{ svg('heroicon-s-bolt', 'size-3 text-yellow-500') }}
                        <div class="flex w-full justify-between">
                            <span>Số người có nguy cơ bị ảnh hưởng</span>
                            <span class="flex size-5 items-center justify-center rounded-full bg-white">0</span>
                        </div>
                    </li>
                    <li class="flex items-center gap-2 py-1.5">
                        {{ svg('heroicon-s-bolt', 'size-3 text-yellow-500') }}
                        <div class="flex w-full justify-between">
                            <span>Diện tích nông nghiệp bị thiệt hại</span>
                            <span class="flex size-5 items-center justify-center rounded-full bg-white">0</span>
                        </div>
                    </li>
                                   <li class="flex items-center gap-2 py-1.5">
                                       {{ svg('heroicon-s-bolt', 'size-3 text-yellow-500') }}
                                       <div class="flex w-full justify-between">
                                           <span>Số điểm nắng nóng (T°C>=35°)</span>
                                           <span class="flex size-5 items-center justify-center rounded-full bg-white">0</span>
                                       </div>
                                   </li>
                </ul>
            </div>
        </div>
    </div>
    
</div>
