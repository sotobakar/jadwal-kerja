<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    // $startOfTheMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
    // $endOfTheMonth = Carbon::now()->endOfMonth()->format('m/d/Y');
    // return [$startOfTheMonth, $endOfTheMonth];
    $shift = Shift::create([
      'code' => '133B',
      'start_time' => '12:00',
      'end_time' => '16:00'
    ]);

    return var_dump($shift);
    // return view('home');
  }
}
