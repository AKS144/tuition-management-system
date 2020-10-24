<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->dateTime('start_date');
            $table->bigInteger('duration');
            $table->timestamps();
            $table->bigInteger('exam_type_id')->unsigned();
            $table->bigInteger('subject_level_id')->unsigned();

            $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete('cascade');
            $table->foreign('subject_level_id')->references('id')->on('subject_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
