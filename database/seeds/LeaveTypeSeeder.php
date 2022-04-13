<?php

use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\LeaveType::create(['name'=>'Casual']);
        \App\Models\LeaveType::create(['name'=>'Sick']);
        \App\Models\LeaveType::create(['name'=>'Earned']);
        \App\Models\LeaveType::create(['name'=>'Unpaid']);
    }
}
