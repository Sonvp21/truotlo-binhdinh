<?php

namespace App\View\Components\Web\Map;

use App\DTOs\WeatherForecastDTO;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WeatherForecastTable extends Component
{
    public function __construct(
        public WeatherForecastDTO $forecast
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.web.map.weather-forecast-table', [
            'forecast' => $this->forecast,
        ]);
    }
}
