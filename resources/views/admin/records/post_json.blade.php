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
    document.getElementById('post-json-form').addEventListener('submit', async function(event) {
        event.preventDefault(); // Ngăn không gửi form theo cách mặc định

        const form = event.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            });

            // Đọc phản hồi JSON
            const result = await response.json();

            if (response.ok) {
                alert(result.success);
                window.location.href = result.redirectUrl; // Chuyển hướng đến trang chỉ định
            } else {
                // Hiển thị thông báo lỗi nếu có
                showValidationErrors(result.errors || {
                    error: result.error
                });
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi khi gửi dữ liệu.');
        }
    });

    function showValidationErrors(errors) {
        const errorDiv = document.getElementById('form-error-json');
        errorDiv.innerHTML = '';

        if (errors) {
            Object.keys(errors).forEach(field => {
                const errorMessage = document.createElement('div');
                errorMessage.classList.add('text-red-500', 'mt-2');
                errorMessage.textContent = errors[field].join(', ');
                errorDiv.appendChild(errorMessage);
            });
        } else {
            const errorMessage = document.createElement('div');
            errorMessage.classList.add('text-red-500', 'mt-2');
            errorMessage.textContent = 'Đã xảy ra lỗi không xác định.';
            errorDiv.appendChild(errorMessage);
        }
    }
</script>
