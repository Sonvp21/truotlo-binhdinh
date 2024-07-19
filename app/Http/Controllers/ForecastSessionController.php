<?php

namespace App\Http\Controllers;

use App\Models\ForecastSession;
use Illuminate\Http\Request;

class ForecastSessionController extends Controller
{
    public function index()
    {
        $sessions = ForecastSession::all();

        $formattedSessions = [];

        foreach ($sessions as $session) {
            $formattedSession = [
                'Nam' => $session->nam,
                'Thang' => $session->thang,
                'Cac_diem' => []
            ];

            // Lấy các điểm dự báo của phiên dự báo hiện tại
            $points = $session->points;

            foreach ($points as $point) {
                $formattedPoint = [
                    'ten_diem' => $point->ten_diem,
                    'vi_tri' => $point->vi_tri,
                    'kinh_do' => $point->kinh_do,
                    'vi_do' => $point->vi_do,
                    'tinh' => $point->tinh,
                    'huyen' => $point->huyen,
                    'xa' => $point->xa,
                    'cac_ngay' => []
                ];

                // Lấy các nguy cơ tương ứng với điểm dự báo hiện tại
                $risks = $point->risks;

                foreach ($risks as $risk) {
                    $formattedRisk = [
                        'ngay' => $risk->ngay,
                        'nguy_co' => $risk->nguy_co
                    ];

                    $formattedPoint['cac_ngay'][] = $formattedRisk;
                }

                $formattedSession['Cac_diem'][] = $formattedPoint;
            }

            $formattedSessions[] = $formattedSession;
        }

        return response()->json($formattedSessions);
    }
    public function show($id)
    {
        // Lấy phiên dự báo dựa trên ID
        $session = ForecastSession::find($id);

        // Kiểm tra nếu phiên dự báo không tồn tại
        if (!$session) {
            return response()->json(['message' => 'Phiên dự báo không tồn tại'], 404);
        }

        // Định dạng lại phiên dự báo
        $formattedSession = [
            'Nam' => $session->nam,
            'Thang' => $session->thang,
            'Cac_diem' => []
        ];

        // Lấy các điểm dự báo của phiên dự báo hiện tại
        $points = $session->points;

        foreach ($points as $point) {
            $formattedPoint = [
                'ten_diem' => $point->ten_diem,
                'vi_tri' => $point->vi_tri,
                'kinh_do' => $point->kinh_do,
                'vi_do' => $point->vi_do,
                'tinh' => $point->tinh,
                'huyen' => $point->huyen,
                'xa' => $point->xa,
                'cac_ngay' => []
            ];

            // Lấy các nguy cơ tương ứng với điểm dự báo hiện tại
            $risks = $point->risks;

            foreach ($risks as $risk) {
                $formattedRisk = [
                    'ngay' => $risk->ngay,
                    'nguy_co' => $risk->nguy_co
                ];

                $formattedPoint['cac_ngay'][] = $formattedRisk;
            }

            $formattedSession['Cac_diem'][] = $formattedPoint;
        }

        // Trả về phản hồi JSON
        return response()->json($formattedSession);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Nam' => 'required|integer',
            'Thang' => 'required|integer',
            'cac_diem' => 'required|array|min:1',
            'cac_diem.*.ten_diem' => 'required|string|max:6',
            'cac_diem.*.vi_tri' => 'required|string',
            'cac_diem.*.kinh_do' => 'required|numeric',
            'cac_diem.*.vi_do' => 'required|numeric',
            'cac_diem.*.tinh' => 'required|string',
            'cac_diem.*.huyen' => 'required|string',
            'cac_diem.*.xa' => 'required|string',
            'cac_diem.*.cac_ngay' => 'required|array|min:1|max:5',
            'cac_diem.*.cac_ngay.*.ngay' => 'required|integer|between:1,31',
            'cac_diem.*.cac_ngay.*.nguy_co' => 'required|string',
        ]);

        $session = ForecastSession::create([
            'nam' => $data['Nam'],
            'thang' => $data['Thang'],
        ]);

        foreach ($data['cac_diem'] as $pointData) {
            $point = $session->points()->create([
                'ten_diem' => $pointData['ten_diem'],
                'vi_tri' => $pointData['vi_tri'],
                'kinh_do' => $pointData['kinh_do'],
                'vi_do' => $pointData['vi_do'],
                'tinh' => $pointData['tinh'],
                'huyen' => $pointData['huyen'],
                'xa' => $pointData['xa'],
            ]);

            foreach ($pointData['cac_ngay'] as $riskData) {
                $point->risks()->create([
                    'ngay' => $riskData['ngay'],
                    'nguy_co' => $riskData['nguy_co'],
                ]);
            }
        }

        return response()->json(['message' => 'Phiên dự báo đã được lưu'], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate request data
        $data = $request->validate([
            'Nam' => 'required|integer',
            'Thang' => 'required|integer',
            'cac_diem' => 'required|array|min:1',
            'cac_diem.*.ten_diem' => 'required|string|max:6',
            'cac_diem.*.vi_tri' => 'required|string',
            'cac_diem.*.kinh_do' => 'required|numeric',
            'cac_diem.*.vi_do' => 'required|numeric',
            'cac_diem.*.tinh' => 'required|string',
            'cac_diem.*.huyen' => 'required|string',
            'cac_diem.*.xa' => 'required|string',
            'cac_diem.*.cac_ngay' => 'required|array|min:1|max:5',
            'cac_diem.*.cac_ngay.*.ngay' => 'required|integer|between:1,31',
            'cac_diem.*.cac_ngay.*.nguy_co' => 'required|string',
        ]);

        // Tìm phiên dự báo cần cập nhật
        $session = ForecastSession::findOrFail($id);

        // Cập nhật thông tin của phiên dự báo
        $session->nam = $data['Nam'];
        $session->thang = $data['Thang'];
        $session->save();

        // Xoá tất cả các điểm dự báo và các nguy cơ tương ứng của phiên dự báo hiện tại
        $session->points()->delete();

        // Tạo lại các điểm dự báo và các nguy cơ mới từ dữ liệu được cập nhật
        foreach ($data['cac_diem'] as $pointData) {
            $point = $session->points()->create([
                'ten_diem' => $pointData['ten_diem'],
                'vi_tri' => $pointData['vi_tri'],
                'kinh_do' => $pointData['kinh_do'],
                'vi_do' => $pointData['vi_do'],
                'tinh' => $pointData['tinh'],
                'huyen' => $pointData['huyen'],
                'xa' => $pointData['xa'],
            ]);

            foreach ($pointData['cac_ngay'] as $riskData) {
                $point->risks()->create([
                    'ngay' => $riskData['ngay'],
                    'nguy_co' => $riskData['nguy_co'],
                ]);
            }
        }

        return response()->json(['message' => 'Phiên dự báo đã được cập nhật'], 200);
    }

    public function destroy($id)
    {
        $session = ForecastSession::findOrFail($id);

        // Xoá các điểm dự báo liên quan
        $session->points()->delete();

        // Xoá phiên dự báo
        $session->delete();

        return response()->json(['message' => 'Đã xoá phiên dự báo thành công'], 200);
    }
}
