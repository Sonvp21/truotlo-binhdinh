<?php

namespace App\View\Components\Web\Aside;

use App\Models\Map\Commune;
use App\Models\Map\District;
use App\Services\WeatherForecastService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Illuminate\View\View; // Make sure to import View class from Illuminate\View

class WeatherForecast extends Component
{
    public $commune_id = 92;
    public $district_id = 7;
    public $commune = null; // Declare as nullable

    public $communes;
    public $districts;

    public function mount()
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

    public function updatedDistrictId($id)
    {
        $this->communes = Commune::query()
            ->where('district_id', $id)
            ->get();

        $this->commune = $this->communes->first();
        $this->commune_id = optional($this->commune)->id;
    }

    public function updatedCommuneId($id)
    {
        $this->commune = Commune::find($id);
    }

    public function render(): View // Adjust the return type to View
    {
        $currentForecast = null;
        $dailyForecast = null;

        if ($this->commune) {
            $currentForecast = cache()->remember('sidebar-current-'.$this->commune->id, 900, function () {
                return app(WeatherForecastService::class)->getCurrent($this->commune->only('lat', 'lon'));
            });

            $dailyForecast = cache()->remember('sidebar-daily-'.$this->commune->id, 900, function () {
                return app(WeatherForecastService::class)->getDaily($this->commune->only('lat', 'lon'));
            });
        }

        return view('components.web.aside.weather-forecast', [
            'currentForecast' => $currentForecast,
            'dailyForecast' => $dailyForecast,
            'placeholder' => $this->placeholder(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
            <div class="h-auto overflow-hidden rounded border border-sky-600 bg-sky-100 shadow">
                <h2 class="flex h-12 items-center bg-sky-600 px-4 text-sm font-bold uppercase shadow">Weather Forecast</h2>
                <div class="h-[345px] flex items-center justify-center">
                    <svg class="size-6 animate-spin text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
            HTML;
    }
}
