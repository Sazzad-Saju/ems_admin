<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'custom_id' => "NC-00".rand(10,99),
        'blood_group_id' => 1,
        'department_id' => 1,
        'designation_id' => 1,
        'name' => $faker->name,
        'personal_email' => $faker->unique()->email,
        'office_email' => $faker->unique()->email,
        'phone' => $faker->numberBetween(10000000,99999999),
        'office_phone' => $faker->numberBetween(10000000,99999999),
        'gender' => $faker->randomElement(['Male','Female']),
        'present_address' => $faker->address,
        'permanent_address' => $faker->address,
        'profile_image' => $faker->randomElement([
        'asset/img/user1-128x128.jpg',
        'asset/img/user2-128x128.jpg',
        'asset/img/user3-128x128.jpg',
        'asset/img/user4-128x128.jpg',
        'asset/img/user5-128x128.jpg',
        'asset/img/user6-128x128.jpg',
        'asset/img/user7-128x128.jpg',
        'asset/img/user8-128x128.jpg'
    ]),
        'dob' => now(),
        'emergency_contact_person' => $faker->name,
        'emergency_contact_phone' => $faker->numberBetween(10000000,9999999),
        'emergency_contact_address' => $faker->address,
        'emergency_contact_relation' => $faker->randomElement(['Uncle','Brother']),
        'nid_number' => $faker->numberBetween(1000000000,999999999),
        'nid_image' => $faker->randomElement([
            'asset/img/user1-128x128.jpg',
            'asset/img/user2-128x128.jpg',
            'asset/img/user3-128x128.jpg',
            'asset/img/user4-128x128.jpg',
            'asset/img/user5-128x128.jpg',
            'asset/img/user6-128x128.jpg',
            'asset/img/user7-128x128.jpg',
            'asset/img/user8-128x128.jpg'
        ]),
        'certificate_image' => $faker->randomElement([
            'asset/img/user1-128x128.jpg',
            'asset/img/user2-128x128.jpg',
            'asset/img/user3-128x128.jpg',
            'asset/img/user4-128x128.jpg',
            'asset/img/user5-128x128.jpg',
            'asset/img/user6-128x128.jpg',
            'asset/img/user7-128x128.jpg',
            'asset/img/user8-128x128.jpg'
        ]),
        'salary' => $faker->numberBetween(10000,99999),
        'join_date' => now(),
    ];
});
