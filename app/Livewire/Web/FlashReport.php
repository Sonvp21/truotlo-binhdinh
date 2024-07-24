<?php

namespace App\Livewire\Web;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class FlashReport extends Component
{
    #[Layout('layouts.web')]
    public function render(): View
    {
        return view('livewire.web.flash-report');
    }
}
