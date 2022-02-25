<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\ScheduleController as EmployeeScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::middleware('role:hrd')->group(function () {
        Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
        Route::get('/schedules/overtime', [ScheduleController::class, 'overtime'])->name('schedules.overtime');
        Route::get('/schedules/leave', [ScheduleController::class, 'leave'])->name('schedules.leave');

        Route::get('/employees/shifts/create', [ShiftController::class, 'create'])->name('employees.shifts.create');
        Route::get('/employees/shifts/edit/{shift_schedule}', [ShiftController::class, 'edit'])->name('employees.shifts.edit');
        Route::post('/employees/shifts', [ShiftController::class, 'createEmployeeShift'])->name('employees.shifts');
        Route::put('/employees/shifts/{shift_schedule}', [ShiftController::class, 'update']);
        Route::delete('/employees/shifts/{shift_schedule}', [ShiftController::class, 'delete']);
    });

    Route::middleware('role:employee')->group(function () {
        Route::get('/my-schedule', [EmployeeScheduleController::class, 'index'])->name('my-schedule');
    });
});

Route::get('/test', [TestController::class, 'index'])->name('test');
