<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\Employee\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request, ScheduleService $service)
    {
        $shift_schedules = $service->handle($request);
        return view('employees.schedules.index', [
            'shift_schedules' => $shift_schedules
        ]);
    }
}
