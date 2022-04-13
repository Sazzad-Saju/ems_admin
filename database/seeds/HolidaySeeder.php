<?php

use App\Models\Holiday;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Holiday::class)->create(
//
//        );

        for($i=0;$i<3;$i++){
            factory(Holiday::class)->create([
                'start'=> \Carbon\Carbon::now()->subDay($i),
                'end'=> \Carbon\Carbon::now()->subDay($i)

            ]);
        }
        factory(Holiday::class)->create([
            'start'=> \Carbon\Carbon::now()->subDay($i),
            'end'=> \Carbon\Carbon::now()->subDay($i),

        ]);
        factory(Holiday::class)->create([
            'start'=> \Carbon\Carbon::now()->subDay($i),
            'end'=> \Carbon\Carbon::now()->subDay($i),

        ]);
        for($i=0;$i<3;$i++){
            factory(Holiday::class)->create([
                'start'=> \Carbon\Carbon::now()->addDay($i),
                'end'=> \Carbon\Carbon::now()->addDay($i),

            ]);
        }

    }
}
