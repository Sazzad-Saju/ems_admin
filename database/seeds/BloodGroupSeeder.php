<?php

use Illuminate\Database\Seeder;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\BloodGroup::create(['name'=>'AB+']);
        \App\Models\BloodGroup::create(['name'=>'AB-']);
        \App\Models\BloodGroup::create(['name'=>'A+']);
        \App\Models\BloodGroup::create(['name'=>'A-']);
        \App\Models\BloodGroup::create(['name'=>'B+']);
        \App\Models\BloodGroup::create(['name'=>'B-']);
        \App\Models\BloodGroup::create(['name'=>'O+']);
        \App\Models\BloodGroup::create(['name'=>'O-']);
    }
}
