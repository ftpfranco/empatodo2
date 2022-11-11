<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time("time1_start")->nullable();
            $table->time("time1_end")->nullable();
            $table->time("time2_start")->nullable();
            $table->time("time2_end")->nullable();
            $table->bigInteger("user_id")->nullable();
            $table->bigInteger("creator_id")->nullable();

            $table->boolean("eliminado")->default(false);
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
        Schema::dropIfExists('turnos');
    }
}
