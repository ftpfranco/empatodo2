<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("titulo")->nullable();
            $table->string("descripcion")->nullable();
            $table->string("nota")->nullable();
            $table->bigInteger("articulo_id")->nullable();
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
        Schema::dropIfExists('notificaciones');
    }
}
