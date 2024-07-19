<?php

namespace App\Services;

use App\DTOs\WeatherForecastDTO;
use App\Enums\OpenWeatherMapEndpointEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class WeatherForecastService
{
    public function getCurrent($coordinates): Collection|WeatherForecastDTO
    {
        return $this->getWeather($coordinates, OpenWeatherMapEndpointEnum::WEATHER);
    }

    public function getDaily($coordinates): Collection|WeatherForecastDTO
    {
        return $this->getWeather($coordinates, OpenWeatherMapEndpointEnum::FORECAST);
    }

    protected function getWeather($coordinates, $endpoint, ...$args): Collection|WeatherForecastDTO
    {
        $response = Http::retry(3, 100)->get(config('services.openweathermap.base_url').$endpoint->value, [
            'lat' => $coordinates['lat'],
            'lon' => $coordinates['lon'],
            'units' => isset($args['lang']) ? $args['lang'] : 'metric',
            'lang' => isset($args['lang']) ? $args['lang'] : 'vi',
            'appid' => config('services.openweathermap.api_key'),
        ]);

        if ($response->collect()->has('list')) {
            return $response->collect()['list'] = collect($response->collect()['list'])->map(function ($item) {
                return $this->getWeatherRequestDTO($item);
            });
        }

        return $this->getWeatherRequestDTO($response->collect());
    }

    protected function getWeatherRequestDTO($response): WeatherForecastDTO
    {
        $weatherDto = new WeatherForecastDTO();
        $weatherDto->icon_code = asset('files/images/openweathermap/clouds/'.$response['weather'][0]['icon'].'.svg');
        $weatherDto->low_temp = $response['main']['temp_min'];
        $weatherDto->high_temp = $response['main']['temp_max'];
        $weatherDto->precip = isset($response['rain']) && isset($response['rain']['1h']) ? $response['rain']['1h'] : 0;
        $weatherDto->phrase = $response['weather'][0]['description'];
        $weatherDto->temp = $response['main']['temp'];
        $weatherDto->obs_time = Carbon::createFromTimestamp($response['dt']);
        $weatherDto->humidity = $response['main']['humidity'];
        $weatherDto->wind_speed = $response['wind']['speed'];
        $weatherDto->wind_dir = $response['wind']['deg'];
        $weatherDto->precip_3hr = isset($response['rain']) && isset($response['rain']['3h']) ? $response['rain']['3h'] : 0;
        $weatherDto->sunrise = isset($response['sys']['sunrise']) ? Carbon::createFromTimestamp($response['sys']['sunrise']) : null;
        $weatherDto->sunset = isset($response['sys']['sunset']) ? Carbon::createFromTimestamp($response['sys']['sunset']) : null;

        return $weatherDto;
    }
}
