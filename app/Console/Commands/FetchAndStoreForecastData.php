<?php

namespace App\Console\Commands;

use App\Models\ForecastRecord;
use App\Models\ForecastSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchAndStoreForecastData extends Command
{
    protected $signature = 'fetch:forecast-data';
    // import in app/Console/Kernel.php and run php artisan fetch:forecast-data
    protected $description = 'Fetch forecast data from API and store it in the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // URL của API
        $url = 'http://truotlobinhdinh.girc.edu.vn/binhdinh/du_bao_5_ngay_sample_value';

        // Lấy dữ liệu từ API
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $sessionData) {
                // Tạo hoặc cập nhật phiên dự báo
                $session = ForecastSession::updateOrCreate(
                    [
                        'nam' => $sessionData['Nam'],
                        'thang' => $sessionData['Thang']
                    ]
                );

                // Xóa các điểm dự báo cũ để cập nhật mới
                $session->points()->delete();

                foreach ($sessionData['Cac_diem'] as $pointData) {
                    // Tạo điểm dự báo
                    $point = $session->points()->create([
                        'ten_diem' => $pointData['ten_diem'],
                        'vi_tri' => $pointData['vi_tri'],
                        'kinh_do' => $pointData['kinh_do'],
                        'vi_do' => $pointData['vi_do'],
                        'tinh' => $pointData['tinh'],
                        'huyen' => $pointData['huyen'],
                        'xa' => $pointData['xa'],
                    ]);

                    if (isset($pointData['cac_ngay'])) {
                        foreach ($pointData['cac_ngay'] as $riskData) {
                            // Tạo nguy cơ cho điểm dự báo
                            $point->risks()->updateOrCreate(
                                ['ngay' => $riskData['ngay']],
                                ['nguy_co' => $riskData['nguy_co']]
                            );
                        }
                    }
                }
            }

            $this->info('Dữ liệu dự báo đã được cập nhật thành công.');
        } else {
            $this->error('Không thể lấy dữ liệu từ API.');
        }
    }
}
