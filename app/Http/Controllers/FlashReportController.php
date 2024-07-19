<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlashReportController extends Controller
{
    public function index()
    {
        return view('web.flash-report');
    }
}
