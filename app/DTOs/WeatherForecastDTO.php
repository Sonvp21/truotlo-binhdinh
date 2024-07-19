<?php

namespace App\DTOs;

use Carbon\Carbon;

class WeatherForecastDTO
{
    /*
    * Weather icon code
    */
    public string $icon_code;

    /*
    * Low temperature
    */

    public float $low_temp;

    /*
    * High temperature
    */
    public float $high_temp;

    /*
    * Precipitation
    */
    public float $precip;

    /*
    * Weather description
    */
    public string $phrase;

    /*
    * Observed time
    */
    public Carbon $obs_time;

    /*
    * Temperature
    */
    public float $temp;

    /*
    * Humidity
    */
    public int $humidity;

    /*
    * Wind speed
    */
    public float $wind_speed;

    /*
    * Wind direction
    */
    public int $wind_dir;

    /*
    * 3hr precipitation
    */
    public ?float $precip_3hr;

    /*
    * Sunrise
    */
    public ?Carbon $sunrise;

    /*
    * Sunset
    */
    public ?Carbon $sunset;
}
