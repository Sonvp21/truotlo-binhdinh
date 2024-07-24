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
                    @foreach ($filter['options'] as $option)
                        <option value="{{ $option[$filter['name']] }}"
                            {{ request($filter['name']) == $option[$filter['name']] ? 'selected' : '' }}>
                            {{ $option[$filter['name']] }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </form>
</div>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lắng nghe sự kiện thay đổi trên các input lọc và ô tìm kiếm
        document.querySelectorAll('.input-bordered, #search').forEach(element => {
            element.addEventListener('change', function() {
                sendAjaxRequest();
            });
        });

        // Lắng nghe sự kiện chuyển trang
        document.getElementById('districtsList').addEventListener('click', function(event) {
            if (event.target.tagName.toLowerCase() === 'a') {
                event.preventDefault();
                const url = event.target.href;
                fetch(url, {
                    method: 'POST', // Gửi yêu cầu POST khi chuyển trang
                    body: new FormData(document.getElementById('filterForm')) // Dữ liệu gửi đi là formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('districtsList').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Hàm gửi yêu cầu Ajax khi thay đổi lọc hoặc tìm kiếm
        function sendAjaxRequest() {
            const formData = new FormData(document.getElementById('filterForm'));
            fetch("{{ route('admin.districts.ajax_list') }}", {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('districtsList').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        }

        // Gọi hàm sendAjaxRequest khi trang web được tải
        sendAjaxRequest();
    });
</script> --}}
