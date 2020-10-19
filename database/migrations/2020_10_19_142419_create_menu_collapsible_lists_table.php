<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuCollapsibleListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_collapse_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('url');
            $table->string('icon');
            $table->bigInteger('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_collapse_lists');
    }
}
