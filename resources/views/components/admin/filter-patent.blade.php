<div class="col-span-2 flex flex-col md:flex-row justify-between">
    <form method="POST" action="{{ $action }}" id="filterForm" class="flex flex-col md:flex-row items-center">
        @csrf
        <div class="form-control mx-1 w-full md:w-1/4">
            <label class="label">
                <span class="label-text">Tìm kiếm</span>
            </label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="input input-sm input-bordered w-32">
        </div>
        @foreach ($filters as $filter)
            <div class="form-control mx-1 w-full md:w-1/4 @if (!in_array($filter['name'], ['district_id', 'legal_representative', 'submission_status'])) hidden @endif">
                <label class="label w-32">
                    <span class="label-text">{{ $filter['label'] }}</span>
                </label>
                <select name="{{ $filter['name'] }}" id="filter{{ ucfirst($filter['name']) }}"
                    class="input input-bordered !h-8 !p-1 text-sm">
                    <option value="">Tất cả</option>
                    @foreach ($filter['options'] as $key => $option)
                        @if ($filter['name'] == 'district_id' || $filter['name'] == 'commune_id' || $filter['name'] == 'submission_status')
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

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>
    $(document).ready(function() {
        var getCommunesUrl = "{{ route('admin.patents.getCommunes', '') }}";

        // Load selected district from session storage on page load (only in create mode)
        var isEditMode = $('input[name="_method"]').length > 0;
        if (!isEditMode) {
            var selectedDistrict = sessionStorage.getItem('selectedDistrict');
            if (selectedDistrict) {
                $('select[name="district_id"]').val(selectedDistrict);
                fetchCommunes(selectedDistrict); // Fetch communes for the selected district on page load
            }
        }

        // Handle district selection change
        $('select[name="district_id"]').change(function() {
            var selectedDistrict = $(this).val();
            if (selectedDistrict) {
                sessionStorage.setItem('selectedDistrict', selectedDistrict);
                sessionStorage.removeItem('selectedCommune'); // Clear selected commune when district changes
                fetchCommunes(selectedDistrict); // Fetch communes when district changes
                $('select[name="commune_id"]').parent().removeClass('hidden'); // Show commune select when district is selected
            } else {
                $('select[name="commune_id"]').empty().parent().addClass('hidden'); // Clear and hide commune select when no district is selected
            }
        });

        // Fetch communes function
        function fetchCommunes(districtId) {
            $.ajax({
                url: getCommunesUrl + "/" + districtId,
                method: 'GET',
                success: function(data) {
                    var communeSelect = $('select[name="commune_id"]');
                    communeSelect.empty();

                    communeSelect.append('<option value="">Chọn xã</option>');
                    data.forEach(function(commune) {
                        communeSelect.append('<option value="' + commune.id + '">' + commune.name + '</option>');
                    });

                    // Select the previously selected commune if available
                    var selectedCommune = sessionStorage.getItem('selectedCommune');
                    if (selectedCommune) {
                        communeSelect.val(selectedCommune);
                    }
                },
                error: function(error) {
                    console.log('Lỗi khi lấy danh sách xã:', error);
                }
            });
        }

        // Trigger district change event on page load if district is already selected
        var selectedDistrictOnLoad = $('select[name="district_id"]').val();
        if (selectedDistrictOnLoad) {
            $('select[name="district_id"]').trigger('change');
        }

        // Handle commune selection change to store in session storage
        $('select[name="commune_id"]').change(function() {
            var selectedCommune = $(this).val();
            sessionStorage.setItem('selectedCommune', selectedCommune);
        });
    });
</script>
