<div class="flex-none space-y-2 px-2 text-center text-sm text-gray-700">
    <div class="flex flex-col">
        <span class="font-bold">{{ $forecast->obs_time->translatedFormat('D') }}</span>
        {{-- <span class="text-xs">{{ $forecast->obs_time->translatedFormat('H') }}</span> --}}
    </div>
    <div>
        <img
            class="m-auto w-8 flex-none"
            src="{{ $forecast->icon_code }}"
            alt="{{ $forecast->icon_code }}"
        />
    </div>
    <div class="flex flex-col">
        <span class="font-bold">{{ $forecast->high_temp }}&deg;</span>
        <span class="text-xs text-slate-500">{{ $forecast->low_temp }}&deg;</span>
    </div>
</div>
