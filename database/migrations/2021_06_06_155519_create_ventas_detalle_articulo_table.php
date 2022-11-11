<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasDetalleArticuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_detalle_articulo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('venta_id')->default(0);
            $table->bigInteger('articulo_id')->default(0);

            $table->string("articulo")->nullable();
            $table->decimal("cantidad",8,0)->nullable();
            $table->decimal("precio",8,2)->nullable();
            $table->decimal("descuento",8,2)->nullable();
            $table->decimal("subtotal",8,2)->nullable();
            $table->text("comentario")->nullable();
            
            $table->boolean("eliminado")->default(false);

            $table->bigInteger("creator_id")->nullable();
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
        Schema::dropIfExists('ventas_detalle_articulo');
    }
}
