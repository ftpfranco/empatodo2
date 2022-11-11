<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger("user_id")->nullable();
            $table->bigInteger("proveedor_id")->nullable();
            $table->decimal("monto",8,2)->nullable();
            
            $table->date("fecha")->nullable();
            $table->time("hora")->nullable();
            
            $table->decimal("descuento_porcentaje",8,2)->nullable();
            $table->decimal("descuento_importe",8,2)->nullable();
            $table->boolean("pago_completo")->default(false);
            
            
            $table->text("comentario",2000)->nullable();

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
        Schema::dropIfExists('compras');
    }
}
