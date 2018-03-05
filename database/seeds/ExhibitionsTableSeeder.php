<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Exhibition;

class ExhibitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        // exhibitions three years ago
        for ($i = 0; $i <= 5; $i++) {
            $start_date = Carbon::createFromTimeStamp($faker->dateTimeBetween('-1000 days', '-700 days')->getTimestamp());
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays(20);
            factory(App\Exhibition::class)->create(['start_date' => $start_date, 'end_date' => $end_date]);
        } 

        // exhibitions two years ago
        for ($i = 0; $i <= 5; $i++) {
            $start_date = Carbon::createFromTimeStamp($faker->dateTimeBetween('-699 days', '-400 days')->getTimestamp());
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays(20);
            factory(App\Exhibition::class)->create(['start_date' => $start_date, 'end_date' => $end_date]);
        } 

        // exhibitions past year
        for ($i = 0; $i <= 5; $i++) {
            $start_date = Carbon::createFromTimeStamp($faker->dateTimeBetween('-399 days', '-40 days')->getTimestamp());
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays(20);
            factory(App\Exhibition::class)->create(['start_date' => $start_date, 'end_date' => $end_date]);
        } 

        //create the exhibition for the current date
        $start_date = Carbon::createFromTimeStamp($faker->dateTimeBetween('-5 days', '-3 days')->getTimestamp());
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays(20);
        factory(App\Exhibition::class)->create(['start_date' => $start_date, 'end_date' => $end_date]);

        // exhibitions this coming year
        for ($i = 0; $i <= 5; $i++) {
            $start_date = Carbon::createFromTimeStamp($faker->dateTimeBetween('+21 days', '+365 days')->getTimestamp());
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays(20);
            factory(App\Exhibition::class)->create(['start_date' => $start_date, 'end_date' => $end_date]);
        } 

    }
}
