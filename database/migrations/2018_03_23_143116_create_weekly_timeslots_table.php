<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\WeeklyTimeslot;

class CreateWeeklyTimeslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_timeslots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day', 10);
            $table->integer('hour');
            $table->boolean('checked')->default(FALSE);
            $table->timestamps();
        });

        //Seed the database with all possible timeslots
        $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        foreach($days as $day){
            for($i = 0; $i <= 23; $i++){
                WeeklyTimeslot::create(['day' => $day, 'hour' => $i]);            
            }            
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_timeslots');
    }
}
