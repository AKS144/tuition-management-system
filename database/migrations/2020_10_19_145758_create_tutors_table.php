<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->bigInteger('mobile_no');
            $table->bigInteger('age');
            $table->string('nric');
            $table->bigInteger('experience');
            $table->dateTime('date_employed');
            $table->bigInteger('status');
            $table->bigInteger('is_active');
            $table->bigInteger('branch_id')->unsigned();
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutors');
    }
}
