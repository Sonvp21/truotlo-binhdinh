<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LandslideDataExport;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $startTime = $request->input('start_time', '00:00');
        $endDate = $request->input('end_date');
        $endTime = $request->input('end_time', '23:59');

        $client = new Client();
        $response = $client->get('http://171.244.133.49/api/getLandSlideRawData');
        $data = json_decode($response->getBody(), true);

        if ($data['status'] === 1) {
            $filteredData = collect($data['data'])->map(function ($item) {
                $contentArray = explode(';', $item['raw_content']);
                $parsedContent = [];
                foreach ($contentArray as $content) {
                    list($key, $value) = explode(',', $content);
                    $parsedContent[trim($key)] = trim($value);
                }

                $calculated_Tilt_A_Or_1_sin = 500 * ((float)$parsedContent['Tilt_A_Or_1(sin)'] - (- 0.001565));
                $calculated_Tilt_A_Or_2_sin = 500 * ((float)$parsedContent['Tilt_A_Or_2(sin)'] - 0.009616);
                $calculated_Tilt_A_Or_3_sin = 500 * ((float)$parsedContent['Tilt_A_Or_3(sin)'] - 0.000935);

                $calculated_Tilt_B_Or_1_sin = 500 * ((float)$parsedContent['Tilt_B_Or_1(sin)'] - (- 0.03261));
                $calculated_Tilt_B_Or_2_sin = 500 * ((float)$parsedContent['Tilt_B_Or_2(sin)'] - (- 0.053559));
                $calculated_Tilt_B_Or_3_sin = 500 * ((float)$parsedContent['Tilt_B_Or_3(sin)'] - (- 0.032529));

                return [
                    'id' => $item['id'],
                    'calculated_Tilt_A_Or_1_sin' => $calculated_Tilt_A_Or_1_sin,
                    'calculated_Tilt_A_Or_2_sin' => $calculated_Tilt_A_Or_2_sin,
                    'calculated_Tilt_A_Or_3_sin' => $calculated_Tilt_A_Or_3_sin,
                    'calculated_Tilt_B_Or_1_sin' => $calculated_Tilt_B_Or_1_sin,
                    'calculated_Tilt_B_Or_2_sin' => $calculated_Tilt_B_Or_2_sin,
                    'calculated_Tilt_B_Or_3_sin' => $calculated_Tilt_B_Or_3_sin,
                    'created_at' => $item['created_at'],
                ];
            });


            if ($startDate && $endDate) {
                $startDateTime = Carbon::parse($startDate . ' ' . $startTime);
                $endDateTime = Carbon::parse($endDate . ' ' . $endTime);
        
                $filteredData = $filteredData->filter(function ($item) use ($startDateTime, $endDateTime) {
                    $itemDate = Carbon::parse($item['created_at']);
                    return $itemDate->between($startDateTime, $endDateTime);
                });
            }

            $chartData = $filteredData->map(function ($item) {
                return [
                    'label' => Carbon::parse($item['created_at'])->format('Y-m-d H:i:s'),
                    'data' => [
                        ['x' => $item['calculated_Tilt_A_Or_1_sin'], 'y' => -6],
                        ['x' => $item['calculated_Tilt_A_Or_2_sin'], 'y' => -11],
                        ['x' => $item['calculated_Tilt_A_Or_3_sin'], 'y' => -16],
                    ],
                ];
            })->values();

            $chartDataB = $filteredData->map(function ($item) {
                return [
                    'label' => Carbon::parse($item['created_at'])->format('Y-m-d H:i:s'),
                    'data' => [
                        ['x' => $item['calculated_Tilt_B_Or_1_sin'], 'y' => -6],
                        ['x' => $item['calculated_Tilt_B_Or_2_sin'], 'y' => -11],
                        ['x' => $item['calculated_Tilt_B_Or_3_sin'], 'y' => -16],
                    ],
                ];
            })->values();

            $chartData->push([
                'label' => 'Bắt đầu',
                'data' => [
                    ['x' => -0.001565, 'y' => -6],
                    ['x' => 0.009616, 'y' => -11],
                    ['x' => 0.000935, 'y' => -16],
                ],
            ]);

            $chartDataB->push([
                'label' => 'Bắt đầu',
                'data' => [
                    ['x' => -0.03261, 'y' => -6],
                    ['x' => -0.053559, 'y' => -11],
                    ['x' => -0.032529, 'y' => -16],
                ],
            ]);

            $lineCount = $chartData->count();

            return view('web.chart', [
                'data' => $filteredData, 
                'chartData' => json_encode($chartData),
                'chartDataB' => json_encode($chartDataB),
                'lineCount' => $lineCount,
                'startDate' => $startDate,
                'startTime' => $startTime,
                'endDate' => $endDate,
                'endTime' => $endTime
            ]);
        } else {
            return view('web.chart', ['data' => [], 'chartData' => json_encode([]),'chartDataB' => json_encode([]), 'lineCount' => 0]);
        }
    }

    public function xuatExcel(Request $request)
    {
        $ngayBatDau = $request->input('start_date');
        $gioBatDau = $request->input('start_time', '00:00');
        $ngayKetThuc = $request->input('end_date');
        $gioKetThuc = $request->input('end_time', '23:59');
    
        $client = new Client();
        $response = $client->get('http://171.244.133.49/api/getLandSlideRawData');
        $data = json_decode($response->getBody(), true);
    
        if ($data['status'] === 1) {
            $duLieuLoc = collect($data['data'])->map(function ($item) {
                $mangNoiDung = explode(';', $item['raw_content']);
                $noiDungPhanTich = [];
                foreach ($mangNoiDung as $noiDung) {
                    list($key, $value) = explode(',', $noiDung);
                    $noiDungPhanTich[trim($key)] = trim($value);
                }
    
                return [
                    'id' => $item['id'],
                    'Batt(Volts)' => $noiDungPhanTich['Batt(Volts)'] ?? '',
                    'Temp_Dataloger(Celsius)' => $noiDungPhanTich['Temp_Dataloger(Celsius)'] ?? '',
                    // 'PZ1_(Digit)' => ((float)($noiDungPhanTich['PZ1_(Digit)'] ?? '')),
                    // 'PZ2_(Digit)' => ((float)($noiDungPhanTich['PZ2_(Digit)'] ?? '')),
                    // 'CR1_(Digit)' =>((float)($noiDungPhanTich['CR1_(Digit)'] ?? '')),
                    // 'CR2_(Digit)' => ((float)($noiDungPhanTich['CR2_(Digit)'] ?? '')),
                    // 'CR3_(Digit)' => ((float)($noiDungPhanTich['CR3_(Digit)'] ?? '')),
                    'PZ1_(Digit)' => isset($noiDungPhanTich['PZ1_(Digit)']) ? -0.09763 * ((float)$noiDungPhanTich['PZ1_(Digit)'] - 9338.196) : '',
                    'PZ2_(Digit)' => isset($noiDungPhanTich['PZ2_(Digit)']) ? -0.0953721 * ((float)$noiDungPhanTich['PZ2_(Digit)'] - 9952.377) : '',
                    'CR1_(Digit)' => isset($noiDungPhanTich['CR1_(Digit)']) ? 0.0452854 * ((float)$noiDungPhanTich['CR1_(Digit)'] - 4645.767) : '',
                    'CR2_(Digit)' => isset($noiDungPhanTich['CR2_(Digit)']) ? 0.0456835 * ((float)$noiDungPhanTich['CR2_(Digit)'] - 6104.228) : '',
                    'CR3_(Digit)' => isset($noiDungPhanTich['CR3_(Digit)']) ? 0.0452898 * ((float)$noiDungPhanTich['CR3_(Digit)'] - 4722.004) : '',
                    'Tilt_A_Or_1(sin)' => isset($noiDungPhanTich['Tilt_A_Or_1(sin)']) ? 500 * ((float)$noiDungPhanTich['Tilt_A_Or_1(sin)'] - (-0.001565)) : '',
                    'Tilt_B_Or_1(sin)' => isset($noiDungPhanTich['Tilt_B_Or_1(sin)']) ? 500 * ((float)$noiDungPhanTich['Tilt_B_Or_1(sin)'] - (-0.03261)) : '',
                    'Tilt_A_Or_2(sin)' => isset($noiDungPhanTich['Tilt_A_Or_2(sin)']) ? 500 * ((float)$noiDungPhanTich['Tilt_A_Or_2(sin)'] - 0.009616) : '',
                    'Tilt_B_Or_2(sin)' => isset($noiDungPhanTich['Tilt_B_Or_2(sin)']) ? 500 * ((float)$noiDungPhanTich['Tilt_B_Or_2(sin)'] - (-0.053559)) : '',
                    'Tilt_A_Or_3(sin)' => isset($noiDungPhanTich['Tilt_A_Or_3(sin)']) ? 500 * ((float)$noiDungPhanTich['Tilt_A_Or_3(sin)'] - 0.000935) : '',
                    'Tilt_B_Or_3(sin)' => isset($noiDungPhanTich['Tilt_B_Or_3(sin)']) ? 500 * ((float)$noiDungPhanTich['Tilt_B_Or_3(sin)'] - (-0.032529)) : '',
                    'PZ1_Temp' => $noiDungPhanTich['PZ1_Temp'] ?? '',
                    'PZ2_Temp' => $noiDungPhanTich['PZ2_Temp'] ?? '',
                    'CR1_Temp' => $noiDungPhanTich['CR1_Temp'] ?? '',
                    'CR2_Temp' => $noiDungPhanTich['CR2_Temp'] ?? '',
                    'CR3_Temp' => $noiDungPhanTich['CR3_Temp'] ?? '',
                    'Tilt_1_Temp' => $noiDungPhanTich['Tilt_1_Temp'] ?? '',
                    'Tilt_2_Temp' => $noiDungPhanTich['Tilt_2_Temp'] ?? '',
                    'Tilt_3_Temp' => $noiDungPhanTich['Tilt_3_Temp'] ?? '',
                    'created_at' => Carbon::parse($item['created_at'])->format('d-m-Y H:i:s'),
                    'updated_at' => Carbon::parse($item['updated_at'])->format('d-m-Y H:i:s'),
                ];
            });
    
            if ($ngayBatDau && $ngayKetThuc) {
                $thoiGianBatDau = Carbon::parse($ngayBatDau . ' ' . $gioBatDau);
                $thoiGianKetThuc = Carbon::parse($ngayKetThuc . ' ' . $gioKetThuc);
        
                $duLieuLoc = $duLieuLoc->filter(function ($item) use ($thoiGianBatDau, $thoiGianKetThuc) {
                    $ngayItem = Carbon::parse($item['created_at']);
                    return $ngayItem->between($thoiGianBatDau, $thoiGianKetThuc);
                });
            }
    
            return Excel::download(new LandslideDataExport($duLieuLoc), 'du_lieu_truot_lo.xlsx');
        }
    
        return back()->with('error', 'Không thể lấy dữ liệu');
    }
}
