<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('purchaser_name');
            $table->string('purchaser_email');
            $table->integer('customer_id')->unsigned();
            $table->integer('artwork_id')->unsigned();
            $table->boolean('collected')->default(FALSE);
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
        Schema::dropIfExists('online_sales');
    }
}
