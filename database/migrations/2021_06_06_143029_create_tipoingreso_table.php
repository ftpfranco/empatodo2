<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoingresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_tipo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("ingresotipo")->nullable();
            $table->bigInteger('creator_id')->default(0);
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
        Schema::dropIfExists('ingreso_tipo');
    }
}
