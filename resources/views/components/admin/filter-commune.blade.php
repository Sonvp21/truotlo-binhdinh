<div class="col-span-2 flex flex-col md:flex-row justify-between">
    <form method="POST" action="{{ $action }}" id="filterForm" class="flex flex-col md:flex-row items-center">
        @csrf
        <div class="form-control mx-1 w-[-webkit-fill-available]">
            <label class="label">
                <span class="label-text">Tìm kiếm</span>
            </label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="input input-sm input-bordered">
        </div>
        @foreach ($filters as $filter)
            <div class="form-control mx-1 w-[-webkit-fill-available]">
                <label class="label">
                    <span class="label-text">{{ $filter['label'] }}</span>
                </label>
                <select name="{{ $filter['name'] }}" id="filter{{ ucfirst($filter['name']) }}"
                    class="input input-bordered !h-8 !p-1 text-sm">
                    <option value="">Tất cả</option>
                    @foreach ($filter['options'] as $key => $option)
                        @if ($filter['name'] == 'district_id')
                            <option value="{{ $key }}"
                                {{ request($filter['name']) == $key ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @else
                            <option value="{{ $option }}"
                                {{ request($filter['name']) == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endforeach

    </form>
</div>
