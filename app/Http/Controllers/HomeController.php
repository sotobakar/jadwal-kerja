<?php

namespace App\Http\Controllers;

use App\Models\ScheduleShift;
use App\Services\ScheduleService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ScheduleService $service)
    {
        $startOfTheMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
        $endOfTheMonth = Carbon::now()->endOfMonth()->format('m/d/Y');
        $month_range = collect([$startOfTheMonth, $endOfTheMonth]);

        // Get count of monthly overtime and leave
        $month['overtime'] = $service->count($month_range, 'overtime');
        $month['leave'] = $service->count($month_range, 'leave');

        $startOfTheWeek = Carbon::now()->startOfWeek()->format('m/d/Y');
        $endOfTheWeek = Carbon::now()->endOfWeek()->format('m/d/Y');
        $week_range = collect([$startOfTheWeek, $endOfTheWeek]);

        // Get count of weekly overtime and leave
        $week['overtime'] = $service->count($week_range, 'overtime');
        $week['leave'] = $service->count($week_range, 'leave');

        // return print_r($month);


        return view('home', [
            'week' => $week,
            'month' => $month
        ]);
    }
}
