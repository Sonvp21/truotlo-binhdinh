<<<<<<< HEAD
<div>
    <nav
    x-data="{ open: false }"
    class="sticky top-0 z-10 bg-sky-600 text-black shadow"
>
    <div
        class="flex h-12 items-center pl-4 md:hidden"
        @click="open = ! open"
    >
        <span x-show="!open">{{ svg('heroicon-o-bars-3', 'size-8') }}</span>
        <span
            x-cloak
            x-show="open"
            >{{ svg('heroicon-o-x-mark', 'size-8') }}</span
        >
    </div>
    <ul
        :class="{'block': open, 'hidden': ! open}"
        class="relative mx-auto hidden h-auto max-w-7xl flex-col px-4 text-sm font-bold uppercase sm:px-6 md:flex md:h-12 md:flex-row md:items-center lg:px-8"
    >
        <li class="h-full">
            <a
                class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white"
                wire:navigate
                href="/"
                >trang chủ</a
            >
        </li>
        <li class="h-full">
            <a
                class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white"
                wire:navigate
                href="/gioi-thieu"
                >GIỚI THIỆU</a
            >
        </li>
        <li class="h-full">
            <a
                class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white"
                wire:navigate
                href="/thong-tin-tuot-lo"
                >THÔNG TIN TRƯỢT LỞ</a
            >
        </li>
        <li class="h-full">
            <a
                class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white"
                href="/bando-gis"
                >BẢN ĐỒ GIS</a
            >
        </li>
        <li class="h-full">
            <a
                class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white"
                wire:navigate
                href="/lien-he"
                >LIÊN HỆ</a
            >
        </li>
    </ul>
</nav>

</div>
=======
<nav x-data="{ open: false }" class="sticky top-0 z-10 bg-sky-600 text-black shadow">
    <div class="flex h-12 items-center pl-4 md:hidden" @click="open = !open">
        <span x-show="!open">{{ svg('heroicon-o-bars-3', 'size-8') }}</span>
        <span x-show="open">{{ svg('heroicon-o-x-mark', 'size-8') }}</span>
    </div>
    <ul :class="{ 'block': open, 'hidden': !open }"
        class="relative mx-auto hidden h-auto max-w-7xl flex-col px-4 text-sm font-bold uppercase sm:px-6 md:flex md:h-12 md:flex-row md:items-center lg:px-8">
        <li class="h-full">
            <a class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white" href="/">Trang chủ</a>
        </li>
        <li class="h-full">
            <a class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white" href="{{ route('about') }}">Giới thiệu</a>
        </li>
        <li class="h-full">
            <a class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white" href="/thong-tin-tuot-lo">Thông tin trượt lở</a>
        </li>
        <li class="h-full">
            <a class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white" href="/bando-gis">Bản đồ GIS</a>
        </li>
        <li class="h-full">
            <a class="flex h-full items-center px-4 py-3 hover:bg-sky-700 hover:text-white" href="/lien-he">Liên hệ</a>
        </li>
    </ul>
</nav>
>>>>>>> 683bbfeddd004eb38bb596b7f24d4996019df57a
