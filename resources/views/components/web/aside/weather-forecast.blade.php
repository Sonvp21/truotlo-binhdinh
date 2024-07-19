<div>
    <div class="h-auto overflow-hidden rounded border border-sky-600 bg-sky-100 shadow">
        <h2 class="flex h-12 items-center bg-sky-600 px-4 text-sm font-bold uppercase shadow">DỰ BÁO THỜI TIẾT</h2>
        <div class="select-none">
            <div class="grid grid-cols-2 divide-x divide-white">
                <div class="pr-2">
                    <select wire:model.live="district_id"
                        class="block w-full border-none bg-transparent px-2 py-3 text-sm text-gray-600 focus:outline-none focus:ring-0">
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pr-2">
                    <select wire:model.live="commune_id"
                        class="block w-full border-none bg-transparent px-2 py-3 text-sm text-gray-600 focus:outline-none focus:ring-0">
                        @foreach ($communes as $comm)
                            <option value="{{ $comm->id }}">{{ $comm->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="relative text-sm">
                <div class="bg-white p-2" wire:loading.class="opacity-60">
                    <div class="p-2">
                        <small class="font-normal italic text-gray-700">Thời tiết hiện tại</small>
                        <h4 class="font-bold">{{ $commune->name ?? null }}, {{ $commune->district->name ?? null }}</h4>
                    </div>
                    <div class="mt-2 p-2">
                        <div class="flex gap-2">
                            <div class="flex gap-2">
                                <img class="m-auto" src="{{ $currentForecast->icon_code ?? null }}" alt="" />
                                <div class="flex items-center">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-3xl font-bold">{{ $currentForecast->temp ?? null }}<sup>&deg;C</sup></span>
                                        <div class="flex flex-col whitespace-nowrap text-xs text-gray-700">
                                            <div>
                                                <b>@lang('web.humidity')</b>: {{ $currentForecast->humidity ?? null }}%
                                            </div>
                                            <div>
                                                <b>@lang('web.wind')</b>: {{ $currentForecast->wind_speed ?? null }}
                                                km/h
                                            </div>
                                            <p>{{ ucfirst($currentForecast->phrase ?? null) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="scrollbar-track-blue-300 scrollbar-thumb-blue-500">
                        <div class="scrollbar-thin w-full overflow-auto">
                            <div class="flex flex-row overflow-y-scroll">
                                @if ($dailyForecast)
                                    @foreach ($dailyForecast as $forecast)
                                        <div class="flex-none space-y-2 px-2 text-center text-sm text-gray-700">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-bold">{{ $forecast->obs_time->translatedFormat('D') }}</span>
                                                <span
                                                    class="text-xs">{{ $forecast->obs_time->translatedFormat('H') }}</span>
                                            </div>
                                            <div>
                                                <img class="m-auto w-8 flex-none" src="{{ $forecast->icon_code }}"
                                                    alt="{{ $forecast->icon_code }}" />
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold">{{ $forecast->high_temp }}&deg;</span>
                                                <span
                                                    class="text-xs text-slate-500">{{ $forecast->low_temp }}&deg;</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Xử lý khi $dailyForecast là null -->
                                    <p>No daily forecast available.</p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-0 hidden" wire:loading.remove.class="hidden">
                    <div class="flex h-full items-center justify-center">
                        <svg class="h-6 w-6 animate-spin text-blue-800" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
