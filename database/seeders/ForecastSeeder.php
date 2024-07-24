<?php

namespace Database\Seeders;

use App\Models\ForecastSession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForecastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $session = ForecastSession::create(['nam' => 2024, 'thang' => 3]);

        $pointsData = [
            [
                'ten_diem' => '100001',
                'vi_tri' => 'Đá Cạnh',
                'kinh_do' => 108.8694,
                'vi_do' => 14.468333,
                'tinh' => 'Bình Định',
                'huyen' => 'An Lão',
                'xa' => 'TT. An Lão',
                'risks' => [
                    ['ngay' => 1, 'nguy_co' => 'Thấp'],
                    ['ngay' => 2, 'nguy_co' => 'Thấp'],
                    // Add more days as needed
                ]
            ],
            // Add more points as needed
        ];

        foreach ($pointsData as $pointData) {
            $point = $session->points()->create([
                'ten_diem' => $pointData['ten_diem'],
                'vi_tri' => $pointData['vi_tri'],
                'kinh_do' => $pointData['kinh_do'],
                'vi_do' => $pointData['vi_do'],
                'tinh' => $pointData['tinh'],
                'huyen' => $pointData['huyen'],
                'xa' => $pointData['xa']
            ]);

            foreach ($pointData['risks'] as $riskData) {
                $point->risks()->create($riskData);
            }
        }
    }
}
