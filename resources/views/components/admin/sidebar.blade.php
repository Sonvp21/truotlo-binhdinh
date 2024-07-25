<div class="drawer-side z-40" style="scroll-behavior: smooth; scroll-padding-top: 5rem;"><label for="drawer"
        class="drawer-overlay" aria-label="Close menu"></label>
    <aside class="bg-base-100 min-h-screen w-80">
        <div data-sveltekit-preload-data
            class="bg-base-100 sticky top-0 z-20 hidden items-center gap-2 bg-opacity-90 px-4 py-2 backdrop-blur lg:flex shadow-md">
            <a href="#" aria-current="page" aria-label="Homepage" class="flex-0 btn btn-ghost px-2">
                <div class="font-title inline-flex text-lg md:text-2xl">Trượt lở - Bình định</div>
            </a>
        </div>
        <div class="h-4"></div>
        <ul class="menu px-4 py-0">
            <li><a href="{{ route('dashboard') }}"
                    class="group font-bold {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fab fa-dashcube"></i>Bảng điều khiển
                </a>
            </li>
            <li></li>
            <li>
                <details {{-- {{ Request::routeIs('admin.districts.*') || Request::routeIs('admin.communes.*') ? 'open' : '' }} --}}>
                    <summary class="font-semibold group">
                        <i class="fad fa-map"></i>Hành chính
                    </summary>
                    <ul>
                        <li>
                            <a href=""
                                class="group font-bold {{ Request::routeIs('admin.districts.*') ? 'active' : '' }}">
                                <i class="far fa-map-marked"></i>
                                Huyện
                            </a>
                        </li>
                        <li>
                            <a href=""
                                class="group font-bold {{ Request::routeIs('admin.communes.*') ? 'active' : '' }}">
                                <i class="far fa-map-marked-alt"></i>
                                Xã
                            </a>
                        </li>
                    </ul>
                </details>
            </li>


            <li {{ Request::routeIs('admin.sessions.*') ? 'open' : '' }}>
                <a href="{{ route('admin.sessions.index') }}"
                    class="group font-bold {{ Request::routeIs('admin.sessions.*') ? 'active' : '' }}">
                    <i class="far fa-map-marked"></i>
                    Dự báo 5 ngày
                </a>
            </li>

            <li {{ Request::routeIs('admin.records.*') ? 'open' : '' }}>
                <a href="{{ route('admin.records.index') }}" class="group font-bold {{ Request::routeIs('admin.records.*') ? 'active' : '' }}">
                    <i class="far fa-map-marked"></i>
                    Cảnh báo theo giờ
                </a>
            </li>

            <li></li>
            <li><a target="_blank" href="{{ route('home') }}" class="font-semibold group">
                    <i class="fad fa-home-alt"></i>
                    Trang chủ
                </a>
            </li>
        </ul>
        <div
            class="bg-base-100 pointer-events-none sticky bottom-0 flex h-40 [mask-image:linear-gradient(transparent,#000000)]">
        </div>
    </aside>
</div>
