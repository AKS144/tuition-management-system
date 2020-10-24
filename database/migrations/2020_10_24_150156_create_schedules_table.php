<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('day_time_slot_id')->unsigned();
            $table->bigInteger('branch_venue_id')->unsigned();

            $table->foreign('day_time_slot_id')->references('id')->on('day_time_slots')->onDelete('cascade');
            $table->foreign('branch_venue_id')->references('id')->on('branch_venues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
