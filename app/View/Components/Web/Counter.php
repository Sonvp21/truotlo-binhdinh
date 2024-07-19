<?php

namespace App\View\Components\Web;

use App\Models\Counter as ModelsCounter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Illuminate\View\Component;
use Illuminate\View\View;

class Counter extends Component
{
    public function render(): View
    {
        $visitor = ModelsCounter::query()
            ->where('user_agent', request()->userAgent())
            ->where('ip', request()->ip())
            ->where('time', '>', (now()->timestamp - 360))->first();

        if (! $visitor) {
            ModelsCounter::query()
                ->updateOrCreate(
                    [
                        'ip' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                        'date' => now()->format('Y-m-d'),
                    ], ['time' => now()->timestamp],
                );
        }

        $counter = DB::table('counters')->count();

        $timestamp = now()->timestamp;

        $counter = DB::table('counters')->count();

        $online = DB::table('counters')
            ->select('time')
            ->whereRaw("(CAST(time AS INTEGER) + 360) >= $timestamp")
            ->get();

        $today = DB::table('counters')
            ->whereDate('date', now()->format('Y-m-d'))
            ->get();

        $month = DB::table('counters')
            ->whereMonth('date', now()->format('m'))
            ->get();

        return view('components.web.counter', [
            'current' => Number::format($online->count(), locale: 'vi'),
            'today' => Number::format($today->count(), locale: 'vi'),
            'month' => Number::format($month->count(), locale: 'vi'),
            'total' => Number::format($counter, locale: 'vi'),
        ]);
    }
}
