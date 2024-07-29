<?php

namespace App\Services;

use App\DTOs\WeatherForecastDTO;
use App\Enums\OpenWeatherMapEndpointEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class WeatherForecastService
{
    public function getCurrent(array $coordinates): ?WeatherForecastDTO
    {
        $endpoint = OpenWeatherMapEndpointEnum::WEATHER->value;
        return $this->getWeather($coordinates, $endpoint);
    }

    public function getDaily(array $coordinates): ?Collection
    {
        $endpoint = '/forecast';
        $response = Http::retry(3, 100)->get(config('services.openweathermap.base_url') . $endpoint, [
            'lat' => $coordinates['lat'],
            'lon' => $coordinates['lon'],
            'units' => 'metric',
            'lang' => 'vi',
            'appid' => config('services.openweathermap.api_key'),
        ]);

        if ($response->successful()) {
            $dailyData = collect($response->json()['list']);

            // Chỉ giữ lại dữ liệu của mỗi ngày một lần
            $groupedByDate = $dailyData->groupBy(function ($item) {
                return Carbon::createFromTimestamp($item['dt'])->format('Y-m-d');
            })->map(function ($items) {
                return $this->getDailyWeatherRequestDTO($items->first());
            });

            return $groupedByDate;
        }

        return null;
    }

    protected function getWeather(array $coordinates, string $endpoint): ?WeatherForecastDTO
    {
        $response = Http::retry(3, 100)->get(config('services.openweathermap.base_url') . $endpoint, [
            'lat' => $coordinates['lat'],
            'lon' => $coordinates['lon'],
            'units' => 'metric',
            'lang' => 'vi',
            'appid' => config('services.openweathermap.api_key'),
        ]);

        if ($response->successful()) {
            $data = $response->json();

            return isset($data['weather']) 
                ? $this->getDailyWeatherRequestDTO($data)
                : null;
        }

        return null;
    }

    protected function getDailyWeatherRequestDTO(array $item): WeatherForecastDTO
    {
        return new WeatherForecastDTO(
            asset('files/images/openweathermap/clouds/'.$item['weather'][0]['icon'].'.svg'),
            $item['main']['temp_min'],
            $item['main']['temp_max'],
            $item['weather'][0]['description'],
            $item['main']['temp'],
            Carbon::createFromTimestamp($item['dt']),
            $item['main']['humidity'],
            $item['wind']['speed'],
            $item['wind']['deg'],
            isset($item['rain']) && isset($item['rain']['3h']) ? $item['rain']['3h'] : 0,
            isset($item['sys']['sunrise']) ? Carbon::createFromTimestamp($item['sys']['sunrise']) : null,
            isset($item['sys']['sunset']) ? Carbon::createFromTimestamp($item['sys']['sunset']) : null
        );
    }
}
