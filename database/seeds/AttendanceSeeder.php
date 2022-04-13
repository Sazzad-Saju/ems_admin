<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = \App\Models\Employee::all();


        foreach ($employees as $e) {
            if ($e->id !== 1) {
                if ($e->id % 2 == 0) {
                    \App\Models\Attendance::create([
                        'employee_id' => $e->id,
                        'date' => Carbon::now()->subDays(1),
                        'start_time' => ['9:10'],
                        'end_time' => ['18:20'],
                    ]);
                } else {
                    \App\Models\Attendance::create([
                        'employee_id' => $e->id,
                        'date' => Carbon::now()->subDays(1),
                        'start_time' => ['9:40'],
                        'end_time' => ['18:20'],
                    ]);
                }
            }
        }

        foreach ($employees as $e) {
            if ($e->id !== 1) {
                if ($e->id % 2 == 0) {
                    \App\Models\Attendance::create([
                        'employee_id' => $e->id,
                        'date' => Carbon::now(),
                        'start_time' => ['9:50'],
                        'end_time' => ['18:20'],
                    ]);
                } else {
                    \App\Models\Attendance::create([
                        'employee_id' => $e->id,
                        'date' => Carbon::now(),
                        'start_time' => ['9:10'],
                        'end_time' => ['18:20'],
                    ]);
                }
            }
        }


        for ($i = 26; $i >= 1; $i--) {
            \App\Models\Attendance::create([
                'employee_id' => 1,
                'date' => Carbon::now()->subDays($i),
                'start_time' => ['9:' . rand(10, 50)],
                'end_time' => ['18:20'],
            ]);
        }

        \App\Models\Attendance::create([
            'employee_id' => 1,
            'date' => Carbon::now(),
            'start_time' => ['9:' . rand(10, 50)],
//            'end_time' => ['18:20'],
        ]);

    }
}
