<?php

use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Designation::create(['name'=>'Technical Officer']);
        \App\Models\Designation::create(['name'=>'Graphic Design']);
        \App\Models\Designation::create(['name'=>'Software Engineer']);
        \App\Models\Designation::create(['name'=>'Network Engineer']);
        \App\Models\Designation::create(['name'=>'SEO Expert']);
    }
}
