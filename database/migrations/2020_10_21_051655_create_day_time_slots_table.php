<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_time_slots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('day_id')->unsigned();
            $table->bigInteger('time_slot_id')->unsigned();

            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade');
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
        Schema::dropIfExists('day_time_slots');
    }
}
