<?php

namespace App\Http\Controllers;

use App\Models\ForecastRecord;
use Illuminate\Http\Request;

class ForecastRecordController extends Controller
{
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

        return response()->json(['message' => 'Record created successfully'], 201);
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

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
