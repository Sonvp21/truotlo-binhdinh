<x-admin-layout>
    <div class="max-w-[100vw] px-6 pb-16 xl:pr-2">
        <div class="flex flex-col-reverse justify-between gap-6 xl:flex-row">
            <div class="p-6 w-full">
                <div class="text-gray-800 text-sm font-semibold leading-tight">
                    <span class="text-gray-800 text-sm flex items-center gap-2 font-semibold leading-tight">
                        Danh sách các phiên dự báo
                    </span>
                </div>
                <x-admin.alerts.success />
                <div class="mt-6">
                    <div class="grid-cols-3 gap-4 pb-3 flex">
                        <div
                            class="ml-auto h-full flex flex-col md:flex-row self-center justify-self-center lg:items-center place-content-center">
                            <div class="mx-2 group hover:text-teal-500">
                                <button onclick="getAllSessions()" type="button"
                                    class="btn glass contents group-hover:text-teal-500">
                                    GET ALL
                                </button>
                            </div>
                            {{-- <div class="mx-2 group hover:text-teal-500">
                                <button type="button" class="btn glass contents group-hover:text-teal-500" 
                                onclick="openModal('add-session-modal')">
                                    POST
                                </button>
                            </div>                             --}}
                            @include('admin.days.post')
                            @include('admin.days.post_json')
                        </div>
                        <dialog id="my_modal_full" class="modal">
                            <div class="modal-box">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                </form>
                                <h3 class="text-lg font-bold">Tất cả phiên dự báo</h3>
                                <div class="flex gap-2">
                                    <button onclick="toggleAllView()" id="toggle-all-view" class="btn mt-4">Xem
                                        JSON</button>
                                    <button onclick="copyToClipboard()" id="copy-button" class="btn mt-4">Copy</button>
                                </div>
                                <textarea id="json-textarea" style="position: absolute; left: -9999px;"></textarea>

                                <div id="all-sessions-content" class="py-4"></div>
                            </div>

                        </dialog>
                    </div>
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Phiên</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sessions as $index => $session)
                                        <tr>
                                            <th>{{ $sessions->firstItem() + $index }}</th>
                                            <td>
                                                <button onclick="openModal({{ $session->id }})">
                                                    Phiên dự báo {{ $session->nam }} - {{ $session->thang }}
                                                </button>
                                            </td>
                                            <td class="flex gap-3">
                                                <button onclick="openModal({{ $session->id }})"><x-heroicon-s-eye
                                                        class="size-4 text-green-600" />
                                                </button>

                                                {{-- Xoá  --}}
                                                <form id="delete-form-{{ $session->id }}"
                                                    action="{{ url('api/binhdinh/du_bao_5_ngay/' . $session->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="button" onclick="confirmDelete({{ $session->id }})">
                                                    <x-heroicon-o-trash class="size-4 text-red-500" />
                                                </button>
                                                <script>
                                                    function confirmDelete(sessionId) {
                                                        if (confirm('Bạn có chắc chắn muốn xóa phiên dự báo này?')) {
                                                            fetch(`/api/binhdinh/du_bao_5_ngay/${sessionId}`, {
                                                                    method: 'DELETE',
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                    }
                                                                })
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    if (data.message) {
                                                                        alert(data.message);
                                                                        location.reload(); // Tải lại trang để cập nhật danh sách
                                                                    }
                                                                })
                                                                .catch(error => console.error('Error:', error));
                                                        }
                                                    }
                                                </script>
                                                {{-- end xoá --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    {{ $sessions->links() }}
                </div>
            </div>
            @foreach ($sessions as $session)
                <dialog id="my_modal_{{ $session->id }}" class="modal">
                    <div class="modal-box">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h3 class="text-lg font-bold" id="modal-title-{{ $session->id }}">Phiên dự báo
                            {{ $session->nam }} - {{ $session->thang }}</h3>
                        <button onclick="toggleView({{ $session->id }})" id="toggle-view-{{ $session->id }}"
                            class="btn mt-4">Xem JSON</button>

                        <div id="modal-content-{{ $session->id }}">
                            <!-- Nội dung chi tiết phiên dự báo sẽ được tải vào đây -->
                        </div>
                    </div>
                </dialog>
            @endforeach
        </div>
    </div>
    <script>
        let sessionData = {}; // Biến để lưu trữ dữ liệu phiên dự báo
        let allSessionsData = null; // Biến để lưu trữ dữ liệu tất cả các phiên dự báo

        function openModal(sessionId) {
            fetch(`/api/binhdinh/du_bao_5_ngay/${sessionId}`)
                .then(response => response.json())
                .then(data => {
                    sessionData[sessionId] = data; // Lưu dữ liệu vào biến sessionData

                    let modalContent = document.getElementById('modal-content-' + sessionId);
                    modalContent.innerHTML = '';

                    let title = document.getElementById('modal-title-' + sessionId);
                    title.innerText = `Phiên dự báo ${data.Nam} - ${data.Thang}`;

                    data.Cac_diem.forEach(point => {
                        let pointElement = document.createElement('div');
                        pointElement.innerHTML = `
                    <h5>Tên điểm: ${point.ten_diem}</h5>
                    <p>Vị trí: ${point.vi_tri}</p>
                    <p>Kinh độ: ${point.kinh_do}</p>
                    <p>Vĩ độ: ${point.vi_do}</p>
                    <p>Tỉnh: ${point.tinh}</p>
                    <p>Huyện: ${point.huyen}</p>
                    <p>Xã: ${point.xa}</p>
                    <h6>Các ngày:</h6>
                    <ul>
                        ${point.cac_ngay.map(risk => `<li>Ngày: ${risk.ngay} - Nguy cơ: ${risk.nguy_co}</li>`).join('')}
                    </ul>
                `;
                        modalContent.appendChild(pointElement);
                    });

                    document.getElementById('my_modal_' + sessionId).showModal();
                })
                .catch(error => console.error('Error:', error));
        }

        function toggleView(sessionId) {
            let modalContent = document.getElementById('modal-content-' + sessionId);
            let toggleButton = document.getElementById('toggle-view-' + sessionId);
            if (toggleButton.innerText === 'Xem JSON') {
                modalContent.innerHTML = '<pre>' + JSON.stringify(sessionData[sessionId], null, 2) + '</pre>';
                toggleButton.innerText = 'Xem bình thường';
            } else {
                openModal(sessionId);
                toggleButton.innerText = 'Xem JSON';
            }
        }

        function getAllSessions() {
            fetch('/api/binhdinh/du_bao_5_ngay')
                .then(response => response.json())
                .then(data => {
                    allSessionsData = data; // Lưu dữ liệu vào biến allSessionsData

                    let allSessionsContent = document.getElementById('all-sessions-content');
                    allSessionsContent.innerHTML = '';

                    data.forEach(session => {
                        let sessionElement = document.createElement('div');
                        sessionElement.innerHTML = `
                    <h4>Phiên dự báo ${session.Nam} - ${session.Thang}</h4>
                    ${session.Cac_diem.map(point => `
                                                <div>
                                                    <h5>${point.ten_diem}</h5>
                                                    <p>Vị trí: ${point.vi_tri}</p>
                                                    <p>Kinh độ: ${point.kinh_do}</p>
                                                    <p>Vĩ độ: ${point.vi_do}</p>
                                                    <p>Tỉnh: ${point.tinh}</p>
                                                    <p>Huyện: ${point.huyen}</p>
                                                    <p>Xã: ${point.xa}</p>
                                                    <h6>Các ngày:</h6>
                                                    <ul>
                                                        ${point.cac_ngay.map(risk => `<li>Ngày: ${risk.ngay} - Nguy cơ: ${risk.nguy_co}</li>`).join('')}
                                                    </ul>
                                                </div>
                                            `).join('')}
                `;
                        allSessionsContent.appendChild(sessionElement);
                    });

                    document.getElementById('my_modal_full').showModal();
                })
                .catch(error => console.error('Error:', error));
        }

        function toggleAllView() {
            let allSessionsContent = document.getElementById('all-sessions-content');
            let toggleButton = document.getElementById('toggle-all-view');
            let textarea = document.getElementById('json-textarea');
            if (toggleButton.innerText === 'Xem JSON') {
                textarea.value = JSON.stringify(allSessionsData, null, 2);
                allSessionsContent.innerHTML = '<pre>' + textarea.value + '</pre>';
                textarea.style.display = 'block';
                toggleButton.innerText = 'Xem bình thường';
            } else {
                getAllSessions();
                textarea.style.display = 'none';
                toggleButton.innerText = 'Xem JSON';
            }
        }

        function copyToClipboard() {
            let textarea = document.getElementById('json-textarea');
            if (textarea.style.display === 'block') {
                textarea.select();
                document.execCommand('copy');
                alert('Đã sao chép nội dung JSON!');
            } else {
                alert('Hiện tại không có nội dung JSON để sao chép.');
            }
        }
    </script>
</x-admin-layout>
