<?php

namespace App\Services;

use DateTime;
use Illuminate\Support\Str;
use App\Models\ScheduleShift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ScheduleService
{
    public function handle(Request $request, $type = null)
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

        // Add query for different types
        if ($type === 'overtime') {
            $shift_schedulesQuery->whereHas('shift', function (Builder $query) {
                $query->where('code', 'like', '%P');
            });
        } elseif ($type === 'leave') {
            $shift_schedulesQuery->whereHas('shift', function (Builder $query) {
                $query->where('code', '=', '4');
            });
        }

        // Where date range
        $shift_schedulesQuery->whereHas('schedule', function (Builder $query) use ($formattedDate) {
            // $query->whereMonth('date', '=', date('m'));
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
        }

        // Return back current date range to view
        $shift_schedules->date_range = $date_range;

        return $shift_schedules;
    }

    public function count($date_range, $type = null)
    {
        // Convert to formatted date for Database query
        $formattedDate = $date_range->map(function ($date) {
            $date = DateTime::createFromFormat('m/d/Y', $date);
            return $date->format('Y-m-d');
        });

        // Where date range
        $schedules = ScheduleShift::whereHas('schedule', function (Builder $query) use ($formattedDate) {
            // $query->whereMonth('date', '=', date('m'));
            $query->whereBetween('date', $formattedDate->toArray());
        });

        // Add query for different types
        if ($type === 'overtime') {
            $schedules->whereHas('shift', function (Builder $query) {
                $query->where('code', 'like', '%P');
            });
        } elseif ($type === 'leave') {
            $schedules->whereHas('shift', function (Builder $query) {
                $query->where('code', '=', '4');
            });
        }

        return $schedules->count();
    }
}
