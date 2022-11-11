<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloActualizarPreciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_actualizar_precios', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->boolean("tipo_precio")->nullable(); // 0 , 1["precio_compra","precio_venta"]
            $table->boolean("accion")->nullable(); // 0, 1  ["incrementar","decrementar"]
            $table->boolean("tipo_monto")->nullable(); // 0, 1 ["importe","porcentaje"]
            $table->decimal("monto",8,2)->default(0);

            $table->jsonb("marcas")->nullable();
            $table->jsonb("categorias")->nullable();

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
        Schema::dropIfExists('articulo_actualizar_precios');
    }
}
