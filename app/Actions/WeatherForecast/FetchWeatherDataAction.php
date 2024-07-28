<?php

namespace App\Actions\WeatherForecast;

use App\DTOs\WeatherForecastDTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class FetchWeatherDataAction
{
    public function __invoke(string $endpoint, array $coordinates, array $args = [])
    {
        $response = Http::retry(3, 100)->get(config('custom.openweathermap.base_url').$endpoint, [
            'lat' => $coordinates['lat'],
            'lon' => $coordinates['lon'],
            'units' => $args['units'] ?? 'metric',
            'lang' => $args['lang'] ?? 'vi',
            'appid' => config('custom.openweathermap.api_key'),
        ]);

        if ($response->collect()->has('list')) {
            return collect($response->collect()['list'])->map(function ($item) {
                return $this->getWeatherRequestDTO($item);
            });
        }

        return null; // or throw an exception
    }

    private function getWeatherRequestDTO(array $item): WeatherForecastDTO
    {
        return new WeatherForecastDTO(
            icon_code: $item['weather'][0]['icon'],
            low_temp: $item['main']['temp_min'],
            high_temp: $item['main']['temp_max'],
            precip: $item['rain']['3h'] ?? 0,
            phrase: $item['weather'][0]['description'],
            obs_time: Carbon::createFromTimestamp($item['dt']),
            temp: $item['main']['temp'],
            humidity: $item['main']['humidity'],
            wind_speed: $item['wind']['speed'],
            wind_dir: $item['wind']['deg'],
            precip_3hr: $item['rain']['3h'] ?? null,
            sunrise: isset($item['sys']['sunrise']) ? Carbon::createFromTimestamp($item['sys']['sunrise']) : null,
            sunset: isset($item['sys']['sunset']) ? Carbon::createFromTimestamp($item['sys']['sunset']) : null
        );
    }
}
