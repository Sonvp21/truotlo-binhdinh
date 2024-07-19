<?php

namespace App\View\Components\Web\Aside;

use App\Models\Map\Commune;
use App\Models\Map\District;
use App\Services\WeatherForecastService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Illuminate\View\View;

class WeatherForecast extends Component
{
    public int $commune_id = 92;
    public int $district_id = 7;
    public ?Commune $commune = null; // Declare as nullable

    public Collection $communes;
    public Collection $districts;

    public function __construct()
    {
        $this->communes = Cache::rememberForever(
            'commune-daily',
            fn () => Commune::query()
                ->with('district')
                ->select('id', 'name')
                ->where('district_id', $this->district_id)
                ->get()
        );

        $this->commune = Cache::rememberForever(
            'communes-'.$this->commune_id,
            fn () => Commune::query()
                ->with('district')
                ->select('name', 'district_id', 'lat', 'lon')
                ->where('id', $this->commune_id)
                ->first()
        );

        $this->districts = Cache::rememberForever('districts', function () {
            return District::all();
        });
    }

    public function updatedDistrictId($id): void
    {
        $this->communes = Commune::query()
            ->where('district_id', $id)
            ->get();

        $this->commune = $this->communes->first();
        $this->commune_id = optional($this->commune)->id;
    }

    public function updatedCommuneId($id): void
    {
        $this->commune = Commune::find($id);
    }

    public function render(): View
    {
        if (!$this->commune) {
            return view('components.web.aside.weather-forecast')->with('currentForecast', null)->with('dailyForecast', null);
        }

        $weatherForecastService = app(WeatherForecastService::class);

        return view('components.web.aside.weather-forecast', [
            'currentForecast' => cache()->remember('sidebar-current-'.$this->commune->id, 900, function () use ($weatherForecastService) {
                return $weatherForecastService->getCurrent($this->commune->only('lat', 'lon'));
            }),
            'dailyForecast' => cache()->remember('sidebar-daily-'.$this->commune->id, 900, function () use ($weatherForecastService) {
                return $weatherForecastService->getDaily($this->commune->only('lat', 'lon'));
            }),
        ]);
    }
}
