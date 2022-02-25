<?php

namespace App\Services\Employee;

use DateTime;
use Illuminate\Support\Str;
use App\Models\ScheduleShift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ScheduleService
{
  public function handle(Request $request)
  {
    // Check if date_range is provided in query
    if ($request->query('date_range')) {
      $date_range = Str::of($request->query('date_range'))->explode(' - ');
    } else {
      // Default to this month schedule
      $startOfTheMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
      $endOfTheMonth = Carbon::now()->endOfMonth()->format('m/d/Y');
      $date_range = collect([$startOfTheMonth, $endOfTheMonth]);
    }

    // Convert to formatted date for Database query
    $formattedDate = $date_range->map(function ($date) {
      $date = DateTime::createFromFormat('m/d/Y', $date);
      return $date->format('Y-m-d');
    });

    // Eager load shift schedules
    $shift_schedulesQuery = ScheduleShift::with('schedule', 'shift', 'user');

    // Get id of authenticated user
    $id = $request->user()->id;

    // Where schedule is for the request->user
    $shift_schedulesQuery->whereHas('user', function (Builder $query) use ($id) {
      $query->where('id', $id);
    });

    // Where date range
    $shift_schedulesQuery->whereHas('schedule', function (Builder $query) use ($formattedDate) {
      $query->whereBetween('date', $formattedDate->toArray());
    });

    // Get rows and sort by date
    $shift_schedules = $shift_schedulesQuery->get()
      ->sortBy(function ($shift_schedule) {
        return $shift_schedule->schedule->date;
      });

    foreach ($shift_schedules as $shift_schedule) {
      if (substr($shift_schedule->shift->code, -1) == 'P') {
        $shift_schedule->shift->status = 'LEMBUR';
      } elseif (substr($shift_schedule->shift->code, -1) == '4') {
        $shift_schedule->shift->status = 'CUTI';
      } else {
        $shift_schedule->shift->status = 'NORMAL';
      }

      $shift_schedule->schedule->date = Carbon::createFromFormat('Y-m-d', $shift_schedule->schedule->date)->locale('id_ID')->isoFormat('dddd, LL');
    }

    // Return back current date range to view
    $shift_schedules->date_range = $date_range;

    return $shift_schedules;
  }
}
