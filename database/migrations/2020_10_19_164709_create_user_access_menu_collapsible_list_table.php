<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccessMenuCollapsibleListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_access_menu_collapse_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('menu_collapse_lists_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();

            $table->foreign('menu_collapse_lists_id')->references('id')->on('menu_collapse_lists')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_access_menu_collapsible_list');
    }
}
