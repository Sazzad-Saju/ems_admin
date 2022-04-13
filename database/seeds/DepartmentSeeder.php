<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Department::create(['name'=>'IT']);
        \App\Models\Department::create(['name'=>'HR']);
        \App\Models\Department::create(['name'=>'Network']);
    }
}
