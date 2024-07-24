<?php

namespace App\Enums;

enum OpenWeatherMapEndpointEnum: string
{
    case WEATHER = '/weather';
    case FORECAST = '/forecast';
    case ONECALL = '/onecall';

    public function value(): string
    {
        return match ($this) {
            self::WEATHER => '/weather',
            self::FORECAST => '/forecast',
            self::ONECALL => '/onecall',
        };
    }
}
