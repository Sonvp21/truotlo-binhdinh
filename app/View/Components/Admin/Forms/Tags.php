<?php

namespace App\View\Components\Admin\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tags extends Component
{
    public $tags;

    public $value;

    public function __construct($tags = [], $value = '')
    {
        $this->tags = $tags;
        $this->value = $value;
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.forms.tags');
    }
}
