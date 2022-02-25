<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleShift;
use App\Models\Shift;
use App\Models\User;
use Error;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    public function create()
    {
        $employees = User::where('role', 'employee')->get();
        $shifts = Shift::get();
        return view('employees.shifts.create', [
            'employees' => $employees,
            'shifts' => $shifts
        ]);
    }

    public function edit(ScheduleShift $shift_schedule)
    {
        $shift_schedule->load('schedule', 'shift', 'user');
        // return print_r($shift_schedule, true);
        $employees = User::where('role', 'employee')->get();
        $shifts = Shift::get();
        return view('employees.shifts.edit', [
            'shift_schedule' => $shift_schedule,
            'employees' => $employees,
            'shifts' => $shifts
        ]);
    }

    public function createEmployeeShift(Request $request)
    {

        $validated = $request->validate([
            'employee' => ['required', 'exists:users,id'],
            'shift' => ['required', 'exists:shifts,id'],
            'date' => ['required', 'date']
        ]);

        $schedule = Schedule::firstOrCreate([
            'date' => $validated['date']
        ]);
        try {
            // Prevent duplicates
            $shiftFound = DB::table('schedule_shift')
                ->where('schedule_id', '=', $schedule->id)
                ->where('user_id', '=', $validated['employee'])
                ->get();

            // A maximum of 20 shifts a month
            // Find total amount of shift that employee have that month
            $totalShifts = ScheduleShift::whereHas('schedule', function (Builder $query) use ($validated) {
                $query->whereMonth('date', '=', date('m', strtotime($validated['date'])));
            })
                ->where('user_id', $validated['employee'])
                ->count();

            if ($totalShifts >= 20) {
                $request->session()->flash('error', 'Pegawai sudah memiliki jumlah shift maksimal');
                return redirect()->route('employees.shifts.create');
            }

            if (sizeof($shiftFound) == 0) {
                DB::table('schedule_shift')->insert([
                    'schedule_id' => $schedule->id,
                    'shift_id' => $validated['shift'],
                    'user_id' => $validated['employee'],
                    "created_at" =>  \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now(),
                ]);

                $request->session()->flash('success', 'Shift berhasil dibuat');
                return redirect()->route('employees.shifts.create');
            } else {
                $request->session()->flash('error', 'Shift sudah ada');
                return redirect()->route('employees.shifts.create');
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Shift gagal dibuat');
            return redirect()->route('employees.shifts.create');
        }
    }

    public function update(Request $request, ScheduleShift $shift_schedule)
    {
        $validated = $request->validate([
            'employee' => ['required', 'exists:users,id'],
            'shift' => ['required', 'exists:shifts,id'],
            'date' => ['required', 'date']
        ]);

        $schedule = Schedule::firstOrCreate([
            'date' => $validated['date']
        ]);
        try {
            // Update model
            if ($shift_schedule->update([
                'user_id' => $validated['employee'],
                'shift_id' => $validated['shift'],
                'schedule_id' => $schedule->id
            ])) {
                $request->session()->flash('success', 'Shift berhasil diupdate');
                return redirect()->route('employees.shifts.edit', [
                    'shift_schedule' => $shift_schedule->id
                ]);
            } else {
                throw new Error();
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Shift gagal dibuat');
            return redirect()->route('employees.shifts.edit', [
                'shift_schedule' => $shift_schedule->id
            ]);
        }
    }

    public function delete(Request $request, ScheduleShift $shift_schedule)
    {
        try {
            // Delete model
            if ($shift_schedule->delete()) {
                $request->session()->flash('success', 'Shift berhasil dihapus');
                return redirect()->route('schedules');
            } else {
                throw new Error();
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Shift gagal dihapus');
            return redirect()->route('schedules');
        }
    }
}
