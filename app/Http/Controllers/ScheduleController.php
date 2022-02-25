<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ScheduleShift;
use App\Services\ScheduleService;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

class ScheduleController extends Controller
{
    public function index(Request $request, ScheduleService $service)
    {
        $shift_schedules = $service->handle($request);
        // return print_r($shift_schedules, true);
        return view('hrd.schedules.index', [
            'shift_schedules' => $shift_schedules
        ]);
    }

    public function overtime(Request $request, ScheduleService $service)
    {
        $shift_schedules = $service->handle($request, 'overtime');
        return view('hrd.schedules.index', [
            'shift_schedules' => $shift_schedules
        ]);
    }

    public function leave(Request $request, ScheduleService $service)
    {
        $shift_schedules = $service->handle($request, 'leave');
        return view('hrd.schedules.index', [
            'shift_schedules' => $shift_schedules
        ]);
    }
}
