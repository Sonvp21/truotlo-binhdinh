<?php

namespace App\View\Components\Admin\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TinymceConfigEnVi extends Component
{
    public string $column;

    public string $columnen;

    public string $model;

    /**
     * Create a new component instance.
     */
    public function __construct(string $column, string $columnen, string $model)
    {
        $this->column = $column;
        $this->columnen = $columnen;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.forms.tinymce-config-en-vi');
    }
}
