<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectLevelPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_level_package', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('subject_level_id')->unsigned();
            $table->bigInteger('package_id')->unsigned();

            $table->foreign('subject_level_id')->references('id')->on('subject_levels')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_level_package');
    }
}
