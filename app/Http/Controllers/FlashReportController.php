<?php

namespace App\Http\Controllers;

use App\Models\ForecastRecord;
use App\Models\ForecastRecordPoint;
use Illuminate\Http\Request;

class FlashReportController extends Controller
{
    public function indexDay()
    {
        return view('web.day-report');
    }

    public function indexRecord()
    {
        // Lấy tất cả các bản ghi dự báo và các điểm liên quan
        $records = ForecastRecord::with('points')->get();

        // Nhóm các điểm dự báo theo huyện
        $districts = $records->flatMap->points->groupBy('huyen');
        // Lấy bản ghi mới nhất để lấy thời gian cập nhật
        $latestRecord = ForecastRecord::orderBy('updated_at', 'desc')->first();
        $latestUpdateTime = $latestRecord ? $latestRecord->updated_at->format('H:i d/m/Y') : 'Chưa có dữ liệu';

        // Lấy danh sách tỉnh
        $provinces = ForecastRecordPoint::select('tinh')->distinct()->get()->pluck('tinh');

        return view('web.record-report', [
            'records' => $records,
            'districts' => $districts,
            'latestUpdateTime' => $latestUpdateTime,
            'provinces' => $provinces,
        ]);
    }
}
