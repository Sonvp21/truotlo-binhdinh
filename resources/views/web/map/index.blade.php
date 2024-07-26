<x-map-layout>
    <div>
        <div x-data="{ sidebar: true }"
            class="flex h-[calc(100vh_-_48px)] select-none bg-slate-200 bg-checkered-pattern">
            <x-web.map.sidebar />
            <div class="h-full w-full" id="map"></div>
        </div>
        <livewire:map.info.landslide />
    </div>
</x-map-layout>
