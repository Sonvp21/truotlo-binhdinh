<?php
namespace App\DTOs;

use Carbon\Carbon;

class WeatherForecastDTO
{
    public string $icon_code;
    public float $low_temp;
    public float $high_temp;
    public string $phrase;
    public float $temp;
    public Carbon $obs_time;
    public int $humidity;
    public float $wind_speed;
    public int $wind_dir;
    public float $precip_3hr;
    public ?Carbon $sunrise;
    public ?Carbon $sunset;

    public function __construct(
        string $icon_code = '',
        float $low_temp = 0,
        float $high_temp = 0,
        string $phrase = '',
        float $temp = 0,
        Carbon $obs_time = null,
        int $humidity = 0,
        float $wind_speed = 0,
        int $wind_dir = 0,
        float $precip_3hr = 0,
        ?Carbon $sunrise = null,
        ?Carbon $sunset = null
    ) {
        $this->icon_code = $icon_code;
        $this->low_temp = $low_temp;
        $this->high_temp = $high_temp;
        $this->phrase = $phrase;
        $this->temp = $temp;
        $this->obs_time = $obs_time;
        $this->humidity = $humidity;
        $this->wind_speed = $wind_speed;
        $this->wind_dir = $wind_dir;
        $this->precip_3hr = $precip_3hr;
        $this->sunrise = $sunrise;
        $this->sunset = $sunset;
    }
}
