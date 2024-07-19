<div class="absolute bottom-5 right-5 z-10 hidden space-y-3 md:block">
    <div class="overflow-hidden shadow">
        <ul class="rounded border border-white bg-white/70 text-slate-500 shadow backdrop-blur-md">
            <li id="reset-center" class="cursor-pointer px-2 py-2 hover:text-lime-700" title="Return">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </li>
            <li id="zoom-in" class="cursor-pointer px-2 py-2 hover:text-lime-700" title="Zoom in">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                </svg>
            </li>
            <li id="zoom-out" class="cursor-pointer px-2 py-2 hover:text-lime-700" title="Zoom out">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                </svg>
            </li>
        </ul>
    </div>
    <div class="overflow-hidden shadow" x-data="{ measure: null }">
        <ul class="rounded border border-white bg-white/70 text-slate-500 shadow backdrop-blur-md">
            <li @click="measure = measure === 'area' ? null : 'area' "
                :class="{ 'bg-red-500 bg-opacity-100 rounded text-white': measure == 'area' }" data-tool="Polygon"
                class="measure-tool cursor-pointer px-2 py-2 hover:text-lime-700" title="Measure area">
                <svg class="relative -right-0.5 h-4 w-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 153 153">
                    <path
                        d="M133.1 81.1l-7.9-43.4c6.4-3.3 10.7-10 10.7-17.7 0-11-9-20-20-20-10.6 0-19.2 8.2-20 18.6L52.2 29.2C48.4 22.5 41.2 18 33 18c-12.2 0-22 9.8-22 22 0 10.1 6.8 18.6 16 21.2v23.4C11.6 87.4 0 100.8 0 117c0 18.2 14.8 33 33 33 17.8 0 32.3-14 33-31.7l44.9-6.4c3.4 7.7 11.1 13.1 20.1 13.1 12.2 0 22-9.9 22-22 0-11.4-8.7-20.8-19.9-21.9zm-11.8 2.1c-6.5 3.2-11.1 9.4-12.1 16.8l-44.9 6.4C60.5 95.2 50.9 86.7 39 84.5V61.2c9-2.5 15.6-10.6 16-20.3l43.9-10.6c3.1 5.1 8.4 8.8 14.6 9.5l7.8 43.4z" />
                </svg>
            </li>
            <li @click="measure = measure === 'line' ? null : 'line' "
                :class="{ 'bg-red-500 bg-opacity-100 text-white rounded': measure == 'line' }" data-tool="LineString"
                class="measure-tool cursor-pointer px-2 py-2 hover:text-lime-700" title="Measure line">
                <svg class="relative -right-0.5 h-4 w-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 153 153">
                    <path
                        d="M153 21c0 11.6-9.5 21-21.3 21-3.5 0-6.8-.8-9.8-2.3L67.5 92.8c4.1 5.9 6.5 13 6.5 20.7 0 20.2-16.6 36.5-37 36.5S0 133.7 0 113.5 16.6 77 37 77c7.9 0 15.2 2.4 21.2 6.6l54.5-53.2c-1.4-2.8-2.3-6-2.3-9.4 0-11.6 9.5-21 21.3-21S153 9.4 153 21z" />
                </svg>
            </li>
            <li @click="measure = measure === 'radius' ? null : 'radius' "
                :class="{ 'bg-red-500 bg-opacity-100 text-white rounded': measure == 'radius' }" data-tool="Circle"
                class="measure-tool cursor-pointer px-2 py-2 hover:text-lime-700" title="Measure radius">
                <svg class="relative -right-0.5 h-4 w-4" stroke="currentColor" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg" id="exLh3Gv469i1" shape-rendering="geometricPrecision"
                    text-rendering="geometricPrecision" viewBox="0 0 16 16">
                    <path fill="none" stroke-width="1.3"
                        d="M2.0355521 8.608429c0-3.6844312 2.9868217-6.6712529 6.6712529-6.6712529s6.6712529 2.9868217 6.6712529 6.6712529-2.9868217 6.6712529-6.6712529 6.6712529-6.6712529-2.9868217-6.6712529-6.6712529Z" />
                    <path stroke-width="0"
                        d="M.631988 3.684006C.631988 1.649386 2.281374 0 4.315994 0S8 1.649386 8 3.684006 6.350614 7.368012 4.315994 7.368012.631988 5.718626.631988 3.684006Z" />
                </svg>
            </li>
        </ul>
    </div>
</div>
