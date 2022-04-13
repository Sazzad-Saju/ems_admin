<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create(['key' => 'app_name', 'value' => 'EMMS']);
        Setting::create(['key' => 'app_url', 'value' => 'localhost:8000']);
        Setting::create(['key' => 'app_email', 'value' => '']);
        Setting::create(['key' => 'app_phone', 'value' => '']);
        Setting::create(['key' => 'office_start_hour', 'value' => '09:00']);
        Setting::create(['key' => 'office_end_hour', 'value' => '18:00']);
        Setting::create(['key' => 'flexible_time', 'value' => '0']);
        Setting::create(['key' => 'casual_leave', 'value' => '5']);
        Setting::create(['key' => 'sick_leave', 'value' => '5']);
        Setting::create(['key' => 'earned_leave', 'value' => '5']);
        Setting::create(['key' => 'unpaid_leave', 'value' => '5']);
        Setting::create(['key' => 'date_format', 'value' => 'DD-MM-YYYY']);
        Setting::create(['key' => 'time_format', 'value' => 'h:mm a']);
        Setting::create(['key' => 'per_page', 'value' => '10']);
        Setting::create(['key' => 'toast_position', 'value' => 'top-end']);
//        Setting::create(['key' => 'timezone', 'value' => 'UTC']);
        Setting::create(['key' => 'timezone', 'value' => 'Asia/Dhaka']);
    }
}
