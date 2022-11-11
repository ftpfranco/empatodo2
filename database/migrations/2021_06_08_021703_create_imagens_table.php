<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagens', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger("articulo_id")->nullable();
            $table->bigInteger("creator_id")->nullable();

            $table->string("imagen")->nullable();
            $table->string("original")->nullable();
            $table->string("thumbnails")->nullable();
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
        Schema::dropIfExists('imagens');
    }
}
