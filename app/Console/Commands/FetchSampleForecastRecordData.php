<?php

namespace App\Console\Commands;

use App\Models\ForecastRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchSampleForecastRecordData extends Command
{
    protected $signature = 'fetch:fetch-sample-forecast-record-data';
    //import in app/Console/Kernel.php and  run php artisan fetch:fetch-sample-forecast-record-data
    protected $description = 'Fetch and store sample forecast data from the API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $url = 'http://truotlobinhdinh.girc.edu.vn/binhdinh/canh_bao_gio_sample_value';
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $forecast) {
                // Tạo hoặc cập nhật bản ghi dự báo
                $record = ForecastRecord::updateOrCreate(
                    [
                        'nam' => $forecast['Nam'],
                        'thang' => $forecast['Thang'],
                        'ngay' => $forecast['Ngay'],
                        'gio' => $forecast['Gio']
                    ]
                );

                // Xóa các điểm dự báo cũ để cập nhật mới
                $record->points()->delete();

                foreach ($forecast['Cac_diem'] as $pointData) {
                    // Tạo điểm dự báo
                    $record->points()->create([
                        'ten_diem' => $pointData['ten_diem'] ?? null,
                        'vi_tri' => $pointData['vi_tri'] ?? null,
                        'kinh_do' => $pointData['kinh_do'] ?? null,
                        'vi_do' => $pointData['vi_do'] ?? null,
                        'tinh' => $pointData['tinh'] ?? null,
                        'huyen' => $pointData['huyen'] ?? null,
                        'xa' => $pointData['xa'] ?? null,
                        'nguy_co' => $pointData['nguy_co'] ?? null,
                    ]);
                }
            }

            $this->info('Dữ liệu dự báo mẫu đã được cập nhật thành công.');
        } else {
            $this->error('Không thể lấy dữ liệu từ API.');
        }
    }
}
