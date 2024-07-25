<div class="mx-2 group hover:text-teal-500">
    <!-- Nút mở modal -->
    <button class="btn glass contents group-hover:text-teal-500"
        onclick="document.getElementById('my_modal_post_json').showModal()">POST JSON</button>
</div>

<!-- Modal -->
<dialog id="my_modal_post_json" class="modal">
    <div class="modal-box">
        <form id="post-json-form" method="POST" action="/api/binhdinh/canh_bao_gio/json" enctype="multipart/form-data">
            @csrf
            <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                onclick="document.getElementById('my_modal_post_json').close()">✕</button>
            <h3 class="text-lg font-bold">Post JSON phiên cảnh báo</h3>

            <!-- Thông báo lỗi nếu có -->
            <div id="form-error-json" class="text-red-500 mt-2"></div>

            <div class="mt-4">
                <!-- Chọn file JSON -->
                <label class="input input-bordered flex items-center gap-2 mb-4">
                    File JSON
                    <input type="file" name="file" accept=".json" required class="grow">
                </label>
                <button type="submit" class="btn mt-4">Lưu Phiên cảnh báo</button>
            </div>
        </form>
    </div>
</dialog>

<script>
    // Form validation and error handling for JSON upload
    document.getElementById('post-json-form').addEventListener('submit', function(event) {
        const form = event.target;
        const isValid = form.checkValidity();

        if (!isValid) {
            event.preventDefault(); // Ngăn không cho gửi form nếu có lỗi
            showValidationErrors(form);
        }
    });

    function showValidationErrors(form) {
        const errorDiv = document.getElementById('form-error-json');
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
