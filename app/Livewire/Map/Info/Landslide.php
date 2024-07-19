<?php

namespace App\Livewire\Map\Info;

use App\Models\Map\Landslide as LandslideModel;
use Livewire\Attributes\On;
use Livewire\Component;

class Landslide extends Component
{
    public int $id = 0;

    public LandslideModel $landslide;

    #[On('get-landslide-info')]
    public function getLandslideInfo($id): void
    {
        $this->landslide = LandslideModel::find($id);
        $this->dispatch('open-dialog');
    }

    public function render()
    {
        return view('livewire.map.info.landslide');
    }
}
