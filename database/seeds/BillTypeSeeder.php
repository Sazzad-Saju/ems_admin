<?php

use Illuminate\Database\Seeder;

class BillTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\BillType::create(['name'=>'Payment']);
        \App\Models\BillType::create(['name'=>'Transport']);
    }
}
