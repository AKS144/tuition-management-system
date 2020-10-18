<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('url');
            $table->string('icon');
            $table->bigInteger('is_active');
            $table->bigInteger('is_collapsible');
            // $table->bigInteger('menu_id');
            // $table->bigInteger('role_id');

            // $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade'); 
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu__lists');
    }
}
