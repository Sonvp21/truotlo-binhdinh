<?php

namespace App\Http\Controllers;

use App\Models\ForecastRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ForecastRecordController extends Controller
{
    public function indexView()
    {
        $records = ForecastRecord::latest()->paginate(10);
        return view('admin.records.index', ['records' => $records]);
    }

    public function index()
    {
        $records = ForecastRecord::with('points')->get();

        $formattedRecords = $records->map(function ($record) {
            return [
                'Nam' => $record->nam,
                'Thang' => $record->thang,
                'Ngay' => $record->ngay,
                'Gio' => $record->gio,
                'Cac_diem' => $record->points->map(function ($point) {
                    return [
                        'ten_diem' => $point->ten_diem,
                        'vi_tri' => $point->vi_tri,
                        'kinh_do' => $point->kinh_do,
                        'vi_do' => $point->vi_do,
                        'tinh' => $point->tinh,
                        'huyen' => $point->huyen,
                        'xa' => $point->xa,
                        'nguy_co' => $point->nguy_co,
                    ];
                }),
            ];
        });

        return response()->json($formattedRecords);
    }

    public function show($id)
    {
        $record = ForecastRecord::with('points')->find($id);

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $formattedRecord = [
            'Nam' => $record->nam,
            'Thang' => $record->thang,
            'Ngay' => $record->ngay,
            'Gio' => $record->gio,
            'Cac_diem' => $record->points->map(function ($point) {
                return [
                    'ten_diem' => $point->ten_diem,
                    'vi_tri' => $point->vi_tri,
                    'kinh_do' => $point->kinh_do,
                    'vi_do' => $point->vi_do,
                    'tinh' => $point->tinh,
                    'huyen' => $point->huyen,
                    'xa' => $point->xa,
                    'nguy_co' => $point->nguy_co,
                ];
            }),
        ];

        return response()->json($formattedRecord);
    }

    public function store(Request $request)
    {
        // Validate input data
        $data = $request->validate([
            'Nam' => 'required|integer',
            'Thang' => 'required|integer',
            'Ngay' => 'required|integer|between:1,31',
            'Gio' => 'required|integer|between:0,23',
            'Cac_diem' => 'nullable|array|min:1',
            'Cac_diem.*.ten_diem' => 'required_if:Cac_diem.*.vi_tri,!=,null|string|max:6',
            'Cac_diem.*.vi_tri' => 'required_if:Cac_diem.*.ten_diem,!=,null|string',
            'Cac_diem.*.kinh_do' => 'required_if:Cac_diem.*.vi_tri,!=,null|numeric',
            'Cac_diem.*.vi_do' => 'required_if:Cac_diem.*.kinh_do,!=,null|numeric',
            'Cac_diem.*.tinh' => 'required_if:Cac_diem.*.vi_do,!=,null|string',
            'Cac_diem.*.huyen' => 'required_if:Cac_diem.*.tinh,!=,null|string',
            'Cac_diem.*.xa' => 'required_if:Cac_diem.*.huyen,!=,null|string',
            'Cac_diem.*.nguy_co' => 'required_if:Cac_diem.*.xa,!=,null|string',
        ]);

        try {
            // Ensure that required fields are set before saving
            if (isset($data['Nam'], $data['Thang'], $data['Ngay'], $data['Gio'])) {
                // Only save if all required fields are present
                $record = ForecastRecord::create([
                    'nam' => $data['Nam'],
                    'thang' => $data['Thang'],
                    'ngay' => $data['Ngay'],
                    'gio' => $data['Gio'],
                ]);

                // Check if Cac_diem exists and is an array
                if (isset($data['Cac_diem']) && is_array($data['Cac_diem'])) {
                    foreach ($data['Cac_diem'] as $pointData) {
                        // Only save point data if it exists
                        if (isset($pointData['ten_diem'], $pointData['vi_tri'], $pointData['kinh_do'], $pointData['vi_do'], $pointData['tinh'], $pointData['huyen'], $pointData['xa'], $pointData['nguy_co'])) {
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
                }

                // Return success response
                return response()->json([
                    'success' => 'Phiên cảnh báo đã được lưu thành công',
                    'redirectUrl' => route('admin.records.index') // URL để chuyển hướng
                ]);
            } else {
                return response()->json([
                    'errors' => ['Thông tin cơ bản chưa được điền đầy đủ.']
                ], 422);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors and return error response
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log general errors and return error response
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

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'error' => 'Tệp JSON không hợp lệ.',
            ], 422); // Unprocessable Entity
        }

        $validator = Validator::make($data, [
            'Nam' => 'required|integer|min:1900|max:2100',
            'Thang' => 'required|integer|between:1,12',
            'Ngay' => 'required|integer|between:1,31',
            'Gio' => 'required|integer|between:0,23',
            'Cac_diem' => 'required|array|min:1',
            'Cac_diem.*.ten_diem' => 'required|string|max:6',
            'Cac_diem.*.vi_tri' => 'required|string',
            'Cac_diem.*.kinh_do' => 'required|numeric',
            'Cac_diem.*.vi_do' => 'required|numeric',
            'Cac_diem.*.tinh' => 'required|string',
            'Cac_diem.*.huyen' => 'required|string',
            'Cac_diem.*.xa' => 'required|string',
            'Cac_diem.*.nguy_co' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Unprocessable Entity
        }

        try {
            $record = ForecastRecord::create([
                'nam' => $data['Nam'],
                'thang' => $data['Thang'],
                'ngay' => $data['Ngay'],
                'gio' => $data['Gio'],
            ]);

            foreach ($data['Cac_diem'] as $pointData) {
                $record->points()->create([
                    'ten_diem' => $pointData['ten_diem'],
                    'vi_tri' => $pointData['vi_tri'],
                    'kinh_do' => $pointData['kinh_do'],
                    'vi_do' => $pointData['vi_do'],
                    'tinh' => $pointData['tinh'],
                    'huyen' => $pointData['huyen'],
                    'xa' => $pointData['xa'],
                    'nguy_co' => $pointData['nguy_co'],
                ]);
            }

            return response()->json([
                'success' => 'Cảnh báo đã được lưu thành công từ JSON',
                'redirectUrl' => route('admin.records.index') // URL để chuyển hướng
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi lưu dữ liệu.'
            ], 500); // Internal Server Error
        }
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'Nam' => 'required|integer',
            'Thang' => 'required|integer',
            'Ngay' => 'required|integer|between:1,31',
            'Gio' => 'required|integer|between:0,23',
            'Cac_diem' => 'required|array|min:1',
            'Cac_diem.*.ten_diem' => 'required|string|max:6',
            'Cac_diem.*.vi_tri' => 'required|string',
            'Cac_diem.*.kinh_do' => 'required|numeric',
            'Cac_diem.*.vi_do' => 'required|numeric',
            'Cac_diem.*.tinh' => 'required|string',
            'Cac_diem.*.huyen' => 'required|string',
            'Cac_diem.*.xa' => 'required|string',
            'Cac_diem.*.nguy_co' => 'required|string',
        ]);

        $record = ForecastRecord::findOrFail($id);

        $record->update([
            'nam' => $data['Nam'],
            'thang' => $data['Thang'],
            'ngay' => $data['Ngay'],
            'gio' => $data['Gio'],
        ]);

        // Delete existing points
        $record->points()->delete();

        // Recreate points with updated data
        foreach ($data['Cac_diem'] as $pointData) {
            $record->points()->create([
                'ten_diem' => $pointData['ten_diem'],
                'vi_tri' => $pointData['vi_tri'],
                'kinh_do' => $pointData['kinh_do'],
                'vi_do' => $pointData['vi_do'],
                'tinh' => $pointData['tinh'],
                'huyen' => $pointData['huyen'],
                'xa' => $pointData['xa'],
                'nguy_co' => $pointData['nguy_co'],
            ]);
        }

        return response()->json(['message' => 'Record updated successfully'], 200);
    }


    public function destroy($id)
    {
        $record = ForecastRecord::findOrFail($id);

        $record->points()->delete();

        $record->delete();

        return response()->json(['message' => 'Xoá thành công'], 200);
    }
}
