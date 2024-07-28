<?php
namespace App\Http\Controllers;

use App\Models\Map\Commune;
use Illuminate\Http\Request;
use App\Services\OpenWeatherMapService;
use App\Models\Xa; // Model cho bảng `xa`

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(OpenWeatherMapService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show(Request $request, $districtId = null)
    {
        $location = $request->input('location', 'Ho Chi Minh'); // Mặc định là 'Ho Chi Minh'

        // Nếu có districtId, lấy tên xã từ bảng `xa`
        if ($districtId) {
            $xa = Commune::find($districtId);
            if ($xa) {
                $location = $xa->ten_xa; // Tên xã
                $coords = $xa->geom; // Dữ liệu tọa độ
                // Cập nhật API để sử dụng tọa độ nếu cần thiết
                $forecast = $this->weatherService->getWeatherForecastByCoords($coords);
            } else {
                return redirect('/weather')->withErrors('Xã không tìm thấy.');
            }
        } else {
            $forecast = $this->weatherService->getWeatherForecast($location);
        }

        return view('web.weather.show', compact('forecast', 'location'));
    }
}
