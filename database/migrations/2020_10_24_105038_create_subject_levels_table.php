<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('level_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();

            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_levels');
    }
}
