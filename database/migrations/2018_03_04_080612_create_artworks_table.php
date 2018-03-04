<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('artist_id')->unsigned();
            $table->string('year_created');
            $table->string('medium');
            $table->float('width_cm');
            $table->float('height_cm');
            $table->float('width_in');
            $table->float('height_in');
            $table->integer('price');
            $table->string('img_1');
            $table->string('img_2');
            $table->string('img_3');
            $table->string('img_sq');
            $table->string('desc_1', 1000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artworks');
    }
}
