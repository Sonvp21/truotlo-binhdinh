<?php

namespace App\Livewire\Web\Aside;

use App\Models\Map\Commune;
use App\Models\Map\District;
use App\Services\WeatherForecastService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;

class WeatherForecast extends Component
{
    public int $commune_id = 92;
    public int $district_id = 7;
    public Commune $commune;
    public Collection $communes;
    public Collection $districts;

    public function mount(): void
    {
        $this->communes = Cache::rememberForever(
            'livewire.commune-daily-' . $this->district_id,
            fn () => Commune::query()
                ->with('district')
                ->select('id', 'ten_xa')
                ->where('district_id', $this->district_id)
                ->get()
        );

        $this->commune = Cache::rememberForever(
            'livewire.communes-' . $this->commune_id,
            fn () => Commune::query()
                ->with('district')
                ->select('ten_xa', 'district_id', 'lat', 'lon')
                ->where('id', $this->commune_id)
                ->first()
        );

        $this->districts = Cache::rememberForever('livewire.districts', function () {
            return District::all();
        });

        // Debugging
        logger()->info('Communes:', $this->communes->toArray());
        logger()->info('Commune:', $this->commune->toArray());
        logger()->info('Districts:', $this->districts->toArray());
    }

    public function updatedDistrictId($id): void
    {
        $this->communes = Commune::query()
            ->where('district_id', $id)
            ->get();
        $this->commune = $this->communes->first();
        $this->commune_id = $this->commune->id;
    }

    public function updatedCommuneId($id): void
    {
        $this->commune = Commune::find($id);
    }

    public function render(WeatherForecastService $weatherForecastService): View
    {
        return view('livewire.web.aside.weather-forecast', [
            'currentForecast' => cache()->remember('sidebar-current-'.$this->commune_id, 900, function () use ($weatherForecastService) {
                return $weatherForecastService->getCurrent($this->commune->only('lat', 'lon'));
            }),
            'dailyForecast' => cache()->remember('sidebar-daily-'.$this->commune_id, 900, function () use ($weatherForecastService) {
                return $weatherForecastService->getDaily($this->commune->only('lat', 'lon'));
            }),
        ]);
    }

    public function placeholder(): string
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
