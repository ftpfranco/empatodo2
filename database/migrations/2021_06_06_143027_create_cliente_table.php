<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("nombre")->nullable();
            $table->string("nombre_fantasia")->nullable();
            $table->string("email")->nullable();
            
            $table->bigInteger("tipo_identificacion_id")->default(1);
            $table->string("nro_dni")->nullable();
            $table->string("telefono")->nullable();
            $table->string("localidad")->nullable();
            $table->string("direccion")->nullable();
            // $table->string("calle")->nullable();
            // $table->string("nro_calle")->nullable();
            // $table->string("piso")->nullable();

            // $table->boolean("tiene_ccorriente")->default(false);
            $table->text("comentario")->nullable();
            
            $table->boolean("habilitado")->default(true);
            $table->boolean("eliminado")->default(false);
            $table->bigInteger('creator_id')->default(0);

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
        Schema::dropIfExists('cliente');
    }
}
