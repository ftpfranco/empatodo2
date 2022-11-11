<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_detalle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("articulo")->nullable();

            $table->decimal("precio_compra",8,2)->nullable();
            $table->decimal("precio_venta",8,2)->nullable();

            $table->decimal("cantidad",8,0)->nullable();
            $table->decimal("subtotal",8,2)->nullable();
            $table->text("comentario",2000)->nullable();

            $table->boolean("eliminado")->default(false);
            $table->bigInteger('creator_id')->default(0);
            $table->bigInteger("compra_id")->nullable();
            $table->bigInteger("articulo_id")->nullable();
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
        Schema::dropIfExists('compra_detalle');
    }
}
