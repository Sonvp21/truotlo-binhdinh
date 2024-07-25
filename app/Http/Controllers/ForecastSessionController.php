<?php

namespace App\Http\Controllers;

use App\Models\ForecastSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ForecastSessionController extends Controller
{
    public function indexView()
    {
        $sessions = ForecastSession::latest()->paginate(10);
        return view('admin.days.index', ['sessions' => $sessions]);
    }

    ///test api
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
        try {
            // Validate the request data
            $data = $request->validate([
                'Nam' => 'required|integer',
                'Thang' => 'required|integer',
                'Cac_diem' => 'nullable|array|min:1', // Allow empty array
                'Cac_diem.*.ten_diem' => 'required_with:Cac_diem|nullable|string|max:6',
                'Cac_diem.*.vi_tri' => 'required_with:Cac_diem|nullable|string',
                'Cac_diem.*.kinh_do' => 'required_with:Cac_diem|nullable|numeric',
                'Cac_diem.*.vi_do' => 'required_with:Cac_diem|nullable|numeric',
                'Cac_diem.*.tinh' => 'required_with:Cac_diem|nullable|string',
                'Cac_diem.*.huyen' => 'required_with:Cac_diem|nullable|string',
                'Cac_diem.*.xa' => 'required_with:Cac_diem|nullable|string',
                'Cac_diem.*.cac_ngay' => 'nullable|array|min:1',
                'Cac_diem.*.cac_ngay.*.ngay' => 'required_with:Cac_diem|nullable|integer|between:1,31',
                'Cac_diem.*.cac_ngay.*.nguy_co' => 'required_with:Cac_diem|nullable|string',
            ]);
    
            // Create the session
            $session = ForecastSession::create([
                'nam' => $data['Nam'],
                'thang' => $data['Thang'],
            ]);
    
            // Only proceed with saving points if Cac_diem exists
            if (isset($data['Cac_diem'])) {
                foreach ($data['Cac_diem'] as $pointData) {
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
                            $point->risks()->create([
                                'ngay' => $riskData['ngay'],
                                'nguy_co' => $riskData['nguy_co'],
                            ]);
                        }
                    }
                }
            }
    
            return response()->json([
                'success' => 'Phiên dự báo đã được lưu thành công',
                'redirectUrl' => route('admin.sessions.index')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('General Error:', ['message' => $e->getMessage()]);
            return response()->json([
                'errors' => ['Đã xảy ra lỗi khi lưu dữ liệu.']
            ], 500);
        }
    }
    

    public function storeFromJson(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json',
        ]);

        $file = $request->file('file');
        $data = json_decode(file_get_contents($file), true);

        // Kiểm tra xem JSON có hợp lệ không
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'errors' => ['Tệp JSON không hợp lệ.']
            ], 422);
        }

        // Validate the JSON data
        $validator = Validator::make($data, [
            'Nam' => 'required|integer',
            'Thang' => 'required|integer',
            'Cac_diem' => 'required|array|min:1',
            'Cac_diem.*.ten_diem' => 'required|string|max:6',
            'Cac_diem.*.vi_tri' => 'required|string',
            'Cac_diem.*.kinh_do' => 'required|numeric',
            'Cac_diem.*.vi_do' => 'required|numeric',
            'Cac_diem.*.tinh' => 'required|string',
            'Cac_diem.*.huyen' => 'required|string',
            'Cac_diem.*.xa' => 'required|string',
            'Cac_diem.*.cac_ngay' => 'required|array|min:1',
            'Cac_diem.*.cac_ngay.*.ngay' => 'required|integer|between:1,31',
            'Cac_diem.*.cac_ngay.*.nguy_co' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $session = ForecastSession::create([
                'nam' => $data['Nam'],
                'thang' => $data['Thang'],
            ]);

            foreach ($data['Cac_diem'] as $pointData) {
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

            return response()->json([
                'success' => 'Phiên dự báo đã được lưu thành công từ JSON',
                'redirectUrl' => route('admin.sessions.index') // URL để chuyển hướng
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'errors' => ['Đã xảy ra lỗi khi lưu dữ liệu.']
            ], 500); // Internal Server Error
        }
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'Nam' => 'required|integer',
            'Thang' => 'required|integer',
            'Cac_diem' => 'required|array|min:1',
            'Cac_diem.*.ten_diem' => 'required|string|max:6',
            'Cac_diem.*.vi_tri' => 'required|string',
            'Cac_diem.*.kinh_do' => 'required|numeric',
            'Cac_diem.*.vi_do' => 'required|numeric',
            'Cac_diem.*.tinh' => 'required|string',
            'Cac_diem.*.huyen' => 'required|string',
            'Cac_diem.*.xa' => 'required|string',
            'Cac_diem.*.cac_ngay' => 'required|array|min:1',
            'Cac_diem.*.cac_ngay.*.ngay' => 'required|integer|between:1,31',
            'Cac_diem.*.cac_ngay.*.nguy_co' => 'required|string',
        ]);

        $session = ForecastSession::findOrFail($id);

        $session->update([
            'nam' => $data['Nam'],
            'thang' => $data['Thang'],
        ]);

        // Xóa tất cả các điểm dự báo và các nguy cơ tương ứng của phiên dự báo hiện tại
        foreach ($session->points as $point) {
            $point->risks()->delete();
            $point->delete();
        }

        // Tạo lại các điểm dự báo và các nguy cơ mới từ dữ liệu được cập nhật
        foreach ($data['Cac_diem'] as $pointData) {
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
