<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuListRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_list_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('menu_list_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();

            $table->foreign('menu_list_id')->references('id')->on('menu_lists')->onDelete('cascade');
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
        Schema::dropIfExists('menu_list_role');
    }
}
