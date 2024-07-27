<x-web-layout>
    <div>
        <h2 class="text-3xl font-extrabold">THÔNG TIN DỰ BÁO TRƯỢT LỞ THEO GIỜ</h2>
        <div class="mt-4">
            <p class="font-bold text-sky-700">Thời gian: {{ $latestUpdateTime }}</p>
            <p class="text-slate-600">
                (Thông tin dự báo chi tiết theo giờ đến cấp xã, liên hệ e-mail: quynhdtgeo
                @gmail.com
                hoặc contact@igevn.com)
            </p>
            <div class="pt-2">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-slate-200 text-sm text-slate-600">
                            <th class="bg-slate-300 p-4" colspan="4">Khu vực</th>
                            <th class="p-4" colspan="5">Nguy cơ trượt lở theo từng giờ</th>
                        </tr>
                        <tr class="text-xs italic text-slate-500 odd:bg-white even:bg-slate-50">
                            <th class="py-1">STT</th>
                            <th>Tỉnh</th>
                            <th>Huyện</th>
                            <th>Vị trí</th>
                            @foreach ($records as $record)
                                <th>{{ $record->gio }}h,{{ $record->ngay }}/{{ $record->thang }}/{{ $record->nam }}</th>
                            @endforeach
                            {{-- <th>Lũ quét</th>
                            <th>Trượt nông</th>
                            <th>Trượt lớn</th> --}}
                        </tr>
                    </thead>
                    <tbody class="text-center" style="text-align: -webkit-center;">
                        @foreach ($districts as $district => $points)
                            @php
                                // Lấy tỉnh từ điểm dự báo đầu tiên
                                $province = $points->first()->tinh;
                                $vi_tri = $points->first()->vi_tri;
                            @endphp
                            <tr class="odd:bg-white even:bg-slate-50">
                                <td class="bg-slate-100 p-2 text-center">{{ $loop->iteration }}</td>
                                <td class="bg-slate-100">{{ $province }}</td>
                                <td class="bg-slate-100">{{ $district }}</td>
                                <td class="bg-slate-100">{{ $vi_tri }}</td>
                                @foreach ($records as $record)
                                    @php
                                        $recordPoint = $record->points->firstWhere('huyen', $district);
                                    @endphp
                                    <td>
                                        @if ($recordPoint)
                                            @if ($recordPoint->nguy_co == 'Không có')
                                                Không có
                                            @elseif ($recordPoint->nguy_co == 'Trung bình')
                                                <img class="size-4"
                                                    src="{{ asset('icon_report/icon_nguy_co_trung_binh.jpg') }}"
                                                    alt="Trung bình">
                                            @elseif ($recordPoint->nguy_co == 'Cao')
                                                <img class="size-4"
                                                    src="{{ asset('icon_report/icon_nguy_co_cao.png') }}"
                                                    alt="Cao">
                                            @elseif ($recordPoint->nguy_co == 'Rất cao')
                                                <img class="size-4"
                                                    src="{{ asset('icon_report/icon_nguy_co_rat_cao.png') }}"
                                                    alt="Rất cao">
                                            @endif
                                        @else
                                            <div class="size-4 rounded-full bg-slate-500"></div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <i class="py-2 text-sm text-slate-700">Các huyện không có trong danh sách không có nguy cơ trượt lở</i>
            </div>

            <div class="pt-4">
                <h3 class="font-bold text-sky-700 my-2">Chú giải các cấp nguy cơ trượt lở:</h3>
                <table class="table w-full">
                    <thead>
                        <tr class="bg-slate-200 text-sm text-slate-600">
                            <th class="whitespace-nowrap p-4">Ký hiệu</th>
                            <th class="whitespace-nowrap p-4 text-left">Nguy cơ</th>
                            <th class="whitespace-nowrap p-4 text-left">Chú giải vắn tắt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-white even:bg-slate-50">
                            <td class="p-2 text-center font-bold" style="text-align: -webkit-center;">
                                <div class="size-4 rounded-full bg-slate-500"></div>
                            </td>
                            <td class="whitespace-nowrap p-2 text-sm">
                                <div class="flex h-full items-center gap-2">Không có</div>
                            </td>
                            <td class="px-4 py-2">Hiếm khi xảy ra trượt lở</td>
                        </tr>
                        <tr class="odd:bg-white even:bg-slate-50">
                            <td class="p-2 text-center font-bold" style="text-align: -webkit-center;">
                                <div class="size-4 rounded-full">
                                    <img src="{{ asset('icon_report/icon_nguy_co_trung_binh.jpg') }}" alt="Trung bình">
                                </div>
                            </td>
                            <td class="whitespace-nowrap p-2 text-sm">
                                <div class="flex h-full items-center gap-2"><span>Trung bình</span></div>
                            </td>
                            <td class="p-2 px-4">Cảnh báo phát sinh trượt lở cục bộ, chủ yếu trượt lở có quy mô nhỏ. Chủ
                                động cảnh giác đối với các khu vực nguy hiểm.</td>
                        </tr>
                        <tr class="odd:bg-white even:bg-slate-50">
                            <td class="p-2 text-center font-bold" style="text-align: -webkit-center;">
                                <div class="size-4 rounded-full">
                                    <img src="{{ asset('icon_report/icon_nguy_co_cao.png') }}" alt="Cao">
                                </div>
                            </td>
                            <td class="whitespace-nowrap p-2 text-sm">
                                <div class="flex h-full items-center gap-2">Cao</div>
                            </td>
                            <td class="p-2 px-4">Cảnh báo nguy cơ trượt lở trên diện rộng, có thể phát sinh trượt lở quy
                                mô lớn. Theo dõi và sẵn sàng ứng phó ở các khu vực nguy hiểm.</td>
                        </tr>
                        <tr class="odd:bg-white even:bg-slate-50">
                            <td class="p-2 text-center font-bold" style="text-align: -webkit-center;">
                                <div class="size-4 rounded-full">
                                    <img src="{{ asset('icon_report/icon_nguy_co_rat_cao.png') }}" alt="Rất cao">
                                </div>
                            </td>
                            <td class="whitespace-nowrap p-2 text-sm">
                                <div class="flex h-full items-center gap-2">Rất cao</div>
                            </td>
                            <td class="p-2 px-4">Trượt lở trên diện rộng, phát sinh trượt lở quy mô lớn. Di chuyển dân
                                trong vùng nguy hiểm đến nơi an toàn.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-web-layout>
