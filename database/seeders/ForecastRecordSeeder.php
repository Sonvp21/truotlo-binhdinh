<?php

namespace Database\Seeders;

use App\Models\ForecastRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForecastRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $record = ForecastRecord::create([
            'nam' => 2024,
            'thang' => 3,
            'ngay' => 7,
            'gio' => 15
        ]);

        $pointsData = [
            [
                'ten_diem' => '100001',
                'vi_tri' => 'Đá Cạnh',
                'kinh_do' => 108.8694,
                'vi_do' => 14.468333,
                'tinh' => 'Bình Định',
                'huyen' => 'An Lão',
                'xa' => 'TT. An Lão',
                'nguy_co' => 'Rất cao'
            ],
            [
                'ten_diem' => '113002',
                'vi_tri' => 'Cổng Chào',
                'kinh_do' => 108.91068,
                'vi_do' => 14.51709,
                'tinh' => 'Bình Định',
                'huyen' => 'An Lão',
                'xa' => 'TT. An Lão',
                'nguy_co' => 'Thấp'
            ],
            // Thêm các điểm tiếp theo tương tự
        ];

        foreach ($pointsData as $pointData) {
            $record->points()->create($pointData);
        }
    }
}
