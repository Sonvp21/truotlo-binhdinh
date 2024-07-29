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
    public ?int $commune_id = 92;
    public int $district_id = 7;
    public ?Commune $commune = null;
    public Collection $communes;
    public Collection $districts;

    public function mount(): void
    {
        $this->loadDistricts();
        $this->loadCommunes();
        $this->loadCommune();
    }

    public function updatedDistrictId($id): void
    {
        $this->commune_id = null; // Reset commune_id khi district_id thay đổi
        $this->loadCommunes();
    }

    public function updatedCommuneId($id): void
    {
        $this->loadCommune();
    }

    protected function loadDistricts(): void
    {
        $this->districts = Cache::rememberForever('livewire.districts', function () {
            return District::all();
        });
    }

    protected function loadCommunes(): void
    {
        $this->communes = Commune::query()
            ->where('district_id', $this->district_id)
            ->select('id', 'ten_xa')
            ->get();

        if ($this->communes->isNotEmpty()) {
            // Cập nhật commune_id nếu cần
            if (is_null($this->commune_id) || !$this->communes->contains('id', $this->commune_id)) {
                $this->commune_id = $this->communes->first()->id;
            }
        } else {
            $this->commune_id = null;
        }

        // Tải commune sau khi cập nhật commune_id
        $this->loadCommune();
    }

    protected function loadCommune(): void
    {
        if ($this->commune_id !== null) {
            $this->commune = Commune::query()
                ->with('district')
                ->select('ten_xa', 'district_id', 'lat', 'lon')
                ->where('id', $this->commune_id)
                ->first();
        } else {
            $this->commune = null;
        }
    }

    public function render(WeatherForecastService $weatherForecastService): View
    {
        $currentForecast = $this->commune ? Cache::remember('sidebar-current-' . $this->commune_id, 900, function () use ($weatherForecastService) {
            return $weatherForecastService->getCurrent($this->commune->only('lat', 'lon'));
        }) : null;
        
        $dailyForecast = $this->commune ? Cache::remember('sidebar-daily-' . $this->commune_id, 900, function () use ($weatherForecastService) {
            return $weatherForecastService->getDaily($this->commune->only('lat', 'lon'));
        }) : null;
    
        return view('livewire.web.aside.weather-forecast', [
            'currentForecast' => $currentForecast,
            'dailyForecast' => $dailyForecast,
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
