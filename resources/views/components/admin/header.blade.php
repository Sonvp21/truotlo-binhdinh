<div class="shadow-md bg-base-100 text-base-content sticky top-0 z-30 flex h-16 w-full justify-center bg-opacity-90 backdrop-blur transition-shadow duration-100 [transform:translate3d(0,0,0)] ">
    <nav class="navbar w-full">
        <div class="flex flex-1 md:gap-1 lg:gap-2"><span
                class="tooltip tooltip-bottom before:text-xs before:content-[attr(data-tip)]"
                data-tip="Menu"><label aria-label="Open menu" for="drawer"
                    class="btn btn-square btn-ghost drawer-button lg:hidden ">
                    <i class="fad fa-bars"></i></label></span>
            <div class="flex items-center gap-2 lg:hidden"><a data-sveltekit-preload-data href="/"
                    aria-current="page" aria-label="Bentre-shtt"
                    class="flex-0 btn btn-ghost gap-1 px-2 md:gap-2"><span class="font-title text-base-content text-lg md:text-2xl">Bentre-shtt</span></a>
            </div>
            <div class="hidden w-full max-w-sm lg:flex"></div>
        </div>
        <div class="dropdown dropdown-bottom dropdown-end">
            <div tabindex="0" role="button" class="btn m-1">
                <div class="w-8 h-8 overflow-hidden rounded-full content-center">
                    <i class="fad fa-user"></i>
                </div>
                <div class="ml-2 capitalize flex ">
                    <h1 class="text-sm text-gray-800 font-semibold m-0 p-0 leading-none">
                        {{ Auth::user()->name }}
                    </h1>
                    <i class="fad fa-chevron-down ml-2 text-xs leading-none"></i>
                </div>
            </div>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                <li><a> <i class="fad fa-user-edit text-xs mr-1"></i>
                        edit my profile</a></li>
                <li></li>
                <li>
                    <a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                class="px-4 py-2 text-gray-600 hover:text-gray-900 focus:ring-indigo-500 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-offset-2">
                                <i class="fad fa-user-times text-xs mr-1"></i>
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </a>
                </li>
            </ul>
        </div>

    </nav>
</div>