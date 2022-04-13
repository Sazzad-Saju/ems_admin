<?php

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Employee::class)->create([
            'custom_id' => 'NC-0005',
            'blood_group_id' => 1,
            'department_id' => 1,
            'designation_id' => 1,
            'name' => 'Mr employee',
            'personal_email' => 'employee@g.com',
            'office_email' => 'employee@g.com',
            'phone' => rand(10000000,9999999),
            'office_phone' => rand(10000000,9999999),
            'gender' => 'Male',
            'present_address' => 'Dhaka, Bangladesh',
            'permanent_address' => 'Dhaka, Bangladesh',
            'profile_image' =>'asset/img/user1-128x128.jpg',
            'dob' => now(),
            'emergency_contact_person' => 'Mr someone',
            'emergency_contact_phone' => rand(10000000,9999999),
            'emergency_contact_address' => 'Dhaka, Bangladesh',
            'emergency_contact_relation' => 'Uncle',
            'nid_number' => rand(1000000000,999999999),
            'nid_image' => 'asset/img/user1-128x128.jpg',
            'certificate_image' => 'asset/img/user2-128x128.jpg',
            'salary' => 15000,
            'join_date' => now(),
        ]);
        factory(Employee::class,10)->create();
    }
}
