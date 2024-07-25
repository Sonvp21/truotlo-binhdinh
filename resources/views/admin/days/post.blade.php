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
            <style>
                .input-bordered p {
                    width: 67px;
                    text-align: center;
                }
            </style>
            <div class="mt-4">
                <!-- Năm -->
                <label class="input input-bordered flex items-center gap-2 mb-4">
                    <p>Năm</p>
                    <input type="number" id="nam" name="Nam" required min="1900" max="2100" class="grow" placeholder="Nhập năm">
                </label>

                <!-- Tháng -->
                <label class="input input-bordered flex items-center gap-2 mb-4">
                    <p>Tháng</p>
                    <input type="number" id="thang" name="Thang" required min="1" max="12" class="grow" placeholder="Nhập tháng">
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
    // Function to add a new forecast point
    function addPoint() {
        const container = document.getElementById('points-container');
        const pointCount = container.querySelectorAll('.point').length;

        const pointDiv = document.createElement('div');
        pointDiv.classList.add('point', 'mb-4', 'p-4', 'border', 'border-gray-300', 'rounded');
        pointDiv.innerHTML = `
            <h4 class="font-bold mb-2">Điểm Dự Báo</h4>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Tên Điểm</p>
                <input type="text" name="Cac_diem[${pointCount}][ten_diem]" required class="grow" placeholder="Nhập tên điểm" maxlength="6">
            </label>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Vị Trí</p>
                <input type="text" name="Cac_diem[${pointCount}][vi_tri]" required class="grow" placeholder="Nhập vị trí">
            </label>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Kinh Độ</p>
                <input type="number" name="Cac_diem[${pointCount}][kinh_do]" step="0.000001" required class="grow" placeholder="Nhập kinh độ">
            </label>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Vĩ Độ</p>
                <input type="number" name="Cac_diem[${pointCount}][vi_do]" step="0.000001" required class="grow" placeholder="Nhập vĩ độ">
            </label>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Tỉnh</p>
                <input type="text" name="Cac_diem[${pointCount}][tinh]" required class="grow" placeholder="Nhập tỉnh">
            </label>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Huyện</p>
                <input type="text" name="Cac_diem[${pointCount}][huyen]" required class="grow" placeholder="Nhập huyện">
            </label>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Xã</p>
                <input type="text" name="Cac_diem[${pointCount}][xa]" required class="grow" placeholder="Nhập xã">
            </label>
            <div id="days-container-${pointCount}" style="margin-top: 10px">
                <!-- Các ngày cho điểm này -->
                <div class="day-entry" style="margin-left: 20px">
                    <label class="input input-bordered flex items-center gap-2 mb-2">
                        <p>Ngày</p>
                        <input type="number" name="Cac_diem[${pointCount}][cac_ngay][0][ngay]" required class="grow" placeholder="Nhập ngày" min="1" max="31">
                    </label>
                    <label class="input input-bordered flex items-center gap-2 mb-2">
                        <p>Nguy Cơ</p>
                        <input type="text" name="Cac_diem[${pointCount}][cac_ngay][0][nguy_co]" required class="grow" placeholder="Nhập nguy cơ">
                    </label>
                </div>
            </div>
            <button type="button" onclick="addDay(this)" class="btn mt-2">Thêm Ngày</button>
        `;
        container.appendChild(pointDiv);
    }

    // Function to add a new day entry to a forecast point
    function addDay(button) {
        const pointDiv = button.closest('.point');
        const daysContainerId = pointDiv.querySelector('[id^="days-container-"]').id;
        const daysContainer = document.getElementById(daysContainerId);
        const dayCount = daysContainer.querySelectorAll('.day-entry').length;

        const dayDiv = document.createElement('div');
        dayDiv.classList.add('day-entry', 'mb-2');
        dayDiv.innerHTML = `
        <div style="margin-left: 20px; margin-top:20px">
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Ngày</p>
                <input type="number" name="Cac_diem[${pointDiv.querySelector('[name^="Cac_diem"]').name.match(/\[(\d+)\]/)[1]}][cac_ngay][${dayCount}][ngay]" required class="grow" placeholder="Nhập ngày" min="1" max="31">
            </label>
            <label class="input input-bordered flex items-center gap-2 mb-2">
                <p>Nguy Cơ</p>
                <input type="text" name="Cac_diem[${pointDiv.querySelector('[name^="Cac_diem"]').name.match(/\[(\d+)\]/)[1]}][cac_ngay][${dayCount}][nguy_co]" required class="grow" placeholder="Nhập nguy cơ">
            </label></div>
        `;
        daysContainer.appendChild(dayDiv);
    }

    // Form validation and error handling
    document.getElementById('post-session-form').addEventListener('submit', function(event) {
        const form = event.target;
        const isValid = form.checkValidity();

        if (!isValid) {
            event.preventDefault(); // Ngăn không cho gửi form nếu có lỗi
            showValidationErrors(form);
        }
    });

    function showValidationErrors(form) {
        const errorDiv = document.getElementById('form-error');
        errorDiv.innerHTML = '';

        const inputs = form.querySelectorAll('input:invalid');
        inputs.forEach(input => {
            const errorMessage = document.createElement('div');
            errorMessage.classList.add('text-red-500', 'mt-2');
            errorMessage.textContent = input.validationMessage;
            errorDiv.appendChild(errorMessage);
        });
    }
</script>
