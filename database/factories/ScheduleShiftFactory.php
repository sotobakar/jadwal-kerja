<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'schedule_id' => Schedule::firstOrCreate([
                'date' => '2022-02-24'
            ]),
            'shift_id' => Shift::all()->random()->id,
            'user_id' => User::where('role', 'employee')->get()->random()->id
        ];
    }
}
