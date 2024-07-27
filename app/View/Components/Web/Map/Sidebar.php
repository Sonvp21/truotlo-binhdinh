<?php

namespace App\View\Components\Web\Map;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $landslides;

    /**
     * Create a new component instance.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $landslides
     * @return void
     */
    public function __construct($landslides)
    {
        $this->landslides = $landslides;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.web.map.sidebar');
    }
}
