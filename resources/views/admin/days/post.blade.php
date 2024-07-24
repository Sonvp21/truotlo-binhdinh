<div class="mx-2 group hover:text-teal-500">
    <!-- Nút mở modal -->
    <button class="btn glass contents group-hover:text-teal-500"
        onclick="document.getElementById('my_modal_post').showModal()">POST</button>
</div>

<!-- Modal -->
<dialog id="my_modal_post" class="modal">
    <div class="modal-box">
        <form id="post-session-form" method="POST" action="/api/binhdinh/du_bao_5_ngay">
            @csrf
            <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                onclick="document.getElementById('my_modal_post').close()">✕</button>
            <h3 class="text-lg font-bold">Post phiên dự báo</h3>

            <!-- Thông báo lỗi nếu có -->
            <div id="form-error" class="text-red-500 mt-2"></div>

            <div class="mt-4">
                <label class="input input-bordered flex items-center gap-2 mb-4">
                    Năm
                    <input type="number" id="nam" name="Nam" required class="grow" placeholder="Nhập năm">
                </label>
                <label class="input input-bordered flex items-center gap-2 mb-4">
                    Tháng
                    <input type="number" id="thang" name="Thang" required class="grow"
                        placeholder="Nhập tháng">
                </label>
                <div id="points-container">
                    <!-- Các điểm dự báo sẽ được thêm vào đây bằng JavaScript -->
                </div>
                <button type="button" onclick="addPoint()" class="btn mt-4">Thêm Điểm</button>
                <button type="submit" class="btn mt-4">Lưu Phiên Dự Báo</button>
            </div>
        </form>
    </div>
</dialog>

<script>
    function addPoint() {
        const container = document.getElementById('points-container');
        const pointCount = container.querySelectorAll('.point').length;

        const pointDiv = document.createElement('div');
        pointDiv.classList.add('point', 'mb-4', 'p-4', 'border', 'border-gray-300', 'rounded');
        pointDiv.innerHTML = `
    <h4 class="font-bold mb-2">Điểm Dự Báo</h4>
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Tên Điểm
        <input type="text" name="Cac_diem[${pointCount}][ten_diem]" required class="grow" placeholder="Nhập tên điểm">
    </label>
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Vị Trí
        <input type="text" name="Cac_diem[${pointCount}][vi_tri]" required class="grow" placeholder="Nhập vị trí">
    </label>
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Kinh Độ
        <input type="number" name="Cac_diem[${pointCount}][kinh_do]" step="0.000001" required class="grow" placeholder="Nhập kinh độ">
    </label>
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Vĩ Độ
        <input type="number" name="Cac_diem[${pointCount}][vi_do]" step="0.000001" required class="grow" placeholder="Nhập vĩ độ">
    </label>
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Tỉnh
        <input type="text" name="Cac_diem[${pointCount}][tinh]" required class="grow" placeholder="Nhập tỉnh">
    </label>
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Huyện
        <input type="text" name="Cac_diem[${pointCount}][huyen]" required class="grow" placeholder="Nhập huyện">
    </label>
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Xã
        <input type="text" name="Cac_diem[${pointCount}][xa]" required class="grow" placeholder="Nhập xã">
    </label>
    <div id="days-container-${pointCount}">
        <!-- Các ngày cho điểm này -->
        <div class="day-entry">
            <label class="input input-bordered flex items-center gap-2 mb-2">
                Ngày
                <input type="number" name="Cac_diem[${pointCount}][cac_ngay][0][ngay]" required class="grow" placeholder="Nhập ngày">
            </label>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                Nguy Cơ
                <input type="text" name="Cac_diem[${pointCount}][cac_ngay][0][nguy_co]" required class="grow" placeholder="Nhập nguy cơ">
            </label>
        </div>
    </div>
    <button type="button" onclick="addDay(this)" class="btn mt-2">Thêm Ngày</button>
`;
        container.appendChild(pointDiv);
    }


    function addDay(button) {
        const pointDiv = button.closest('.point');
        const daysContainerId = pointDiv.querySelector('[id^="days-container-"]').id;
        const daysContainer = document.getElementById(daysContainerId);
        const dayCount = daysContainer.querySelectorAll('.day-entry').length;

        const dayDiv = document.createElement('div');
        dayDiv.classList.add('day-entry', 'mb-2');
        dayDiv.innerHTML = `
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Ngày
        <input type="number" name="Cac_diem[${pointDiv.querySelector('[name^="Cac_diem"]').name.match(/\[(\d+)\]/)[1]}][cac_ngay][${dayCount}][ngay]" required class="grow" placeholder="Nhập ngày">
    </label>
    <label class="input input-bordered flex items-center gap-2 mb-2">
        Nguy Cơ
        <input type="text" name="Cac_diem[${pointDiv.querySelector('[name^="Cac_diem"]').name.match(/\[(\d+)\]/)[1]}][cac_ngay][${dayCount}][nguy_co]" required class="grow" placeholder="Nhập nguy cơ">
    </label>
`;
        daysContainer.appendChild(dayDiv);
    }
</script>
