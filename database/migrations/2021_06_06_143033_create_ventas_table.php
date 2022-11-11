<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date("fecha")->nullable();
            $table->time("hora")->nullable();
            $table->decimal("monto",8,2)->nullable();
            // punto_venta + codigo = codigo_venta
            
            $table->decimal("descuento_porcentaje",8,2)->nullable();
            $table->decimal("descuento_importe",8,2)->nullable();
            $table->boolean("pago_completo")->default(false);
            $table->string("cae")->nullable(); // codigo de facturacion electronica emitida
            $table->decimal("punto_venta")->nullable();
            $table->decimal("codigo")->nullable();
            
            
            $table->text("comentario",2000)->nullable();
            // $table->bigInteger('creator_id')->default(0);
            $table->bigInteger('cliente_id')->nullable();
            
            $table->bigInteger("user_id")->nullable();
            $table->bigInteger("caja_id")->nullable();
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
        Schema::dropIfExists('ventas');
    }
}
