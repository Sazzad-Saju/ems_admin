<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Holiday;
use Faker\Generator as Faker;

$factory->define(Holiday::class, function (Faker $faker) {
    return [
        'title'=> $faker->text(10),
        'description'=> $faker->text(200),
        'start'=> \Carbon\Carbon::now(),
        'end'=> \Carbon\Carbon::now(),
        'type'=>$faker->randomElement([
            'Holiday','Reserved','Flexible'
        ])
    ];
});
