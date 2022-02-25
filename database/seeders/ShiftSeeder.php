<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'code' => '1',
                'start_time' => '07:00',
                'end_time' => '16:00'
            ],
            [
                'code' => '12',
                'start_time' => '11:00',
                'end_time' => '20:00'
            ],
            [
                'code' => '2',
                'start_time' => '15:00',
                'end_time' => '00:00'
            ],
            [
                'code' => '3',
                'start_time' => '23:00',
                'end_time' => '08:00'
            ],
            [
                'code' => '1P',
                'start_time' => '07:00',
                'end_time' => '20:30'
            ],
            [
                'code' => '12P',
                'start_time' => '10:00',
                'end_time' => '23:30'
            ],
            [
                'code' => '3P',
                'start_time' => '19:00',
                'end_time' => '08:30'
            ],
            [
                'code' => '4',
                'start_time' => '00:00',
                'end_time' => '00:00'
            ],
        ];
        Shift::insert($data);
    }
}
