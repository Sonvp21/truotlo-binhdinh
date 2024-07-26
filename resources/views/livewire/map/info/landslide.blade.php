<div>
    <input type="checkbox" id="landslide-info-dialog" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="text-lg font-bold">@lang('web.landslide_info')</h3>
            @if ($landslide)
                <div class="mt-4">
                    <table class="table">
                        <tbody>
                            <tr class="odd:bg-base-200">
                                <th>@lang('web.commune')</th>
                                <td>{{ $landslide->ten_xa }}</td>
                            </tr>
                            <tr class="odd:bg-base-200">
                                <th>@lang('web.district')</th>
                                <td>{{ $landslide->district?->ten_huyen }}</td>
                            </tr>
                            <tr class="odd:bg-base-200">
                                <th style="width: 110px;">@lang('web.location')/Điểm</th>
                                <td>{{ $landslide->vi_tri }}</td>
                            </tr>
                            <tr class="odd:bg-base-200">
                                <th>@lang('web.description')</th>
                                <td>{{ $landslide->mo_ta }}</td>
                            </tr>
                            <tr class="odd:bg-base-200">
                                <th style="width: 100px;">@lang('web.coordinates')</th>
                                <td>Kinh độ: {{ $landslide->lon }}, Vĩ độ: {{ $landslide->lat }} </td>
                            </tr>
                        </tbody>
                    </table>

                    @php
                        $objectId = $landslide->object_id;
                        $directoryPath = public_path("files/images/map/landslide/{$objectId}");
                        $filesExist = is_dir($directoryPath);
                        $files = $filesExist ? array_diff(scandir($directoryPath), ['.', '..']) : [];
                        $files = array_values($files);
                        $imageUrls = array_map(function ($file) use ($objectId) {
                            return asset("files/images/map/landslide/{$objectId}/{$file}");
                        }, $files);
                    @endphp

                    <p><strong>Hình ảnh:</strong></p>
                    <div class="carousel w-full">
                        @foreach ($imageUrls as $index => $url)
                            <div id="item{{ $index + 1 }}" class="carousel-item w-full">
                                <img src="{{ $url }}" class="w-full" alt="Image {{ $index + 1 }}" />
                            </div>
                        @endforeach
                    </div>
                    <div class="flex w-full justify-center gap-2 py-2">
                        @foreach ($imageUrls as $index => $url)
                            <a href="#item{{ $index + 1 }}" class="btn btn-xs">{{ $index + 1 }}</a>
                        @endforeach
                    </div>


                </div>
            @endif
            <div class="modal-action mt-0">
                <div class="modal-action mt-2">
                    <label for="landslide-info-dialog" class="btn">@lang('web.buttons.close')</label>
                </div>
            </div>
        </div>
    </div>
    @script
        <script>
            $wire.on('open-dialog', () => {
                console.log('e')
                document.getElementById('landslide-info-dialog').checked = true
            })
        </script>
    @endscript
</div>
