<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UsersTableSeeder::class);
         $this->call(EmployeeSeeder::class);
         $this->call(DepartmentSeeder::class);
         $this->call(DesignationSeeder::class);
         $this->call(BloodGroupSeeder::class);
         $this->call(LeaveTypeSeeder::class);
         $this->call(BillTypeSeeder::class);
         $this->call(SettingSeeder::class);
         $this->call(AttendanceSeeder::class);
         $this->call(HolidaySeeder::class);

         \App\Models\User::create([
             'name'=>'Admin',
             'email'=>'admin@mail.com',
             'password'=>Hash::make(12345678),
             'gender'=>'Male',
             'phone'=>'1-308-768-3964',
         ]);
    }
}
