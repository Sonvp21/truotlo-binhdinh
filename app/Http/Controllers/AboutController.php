<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('components.web.about'); // Trả về view 'about.blade.php'
    }
}
