<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasDetallePagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras_detalle_pago', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("compra_id")->nullable();
            // $table->bigInteger("tipopago_id")->nullable();
            // $table->decimal("monto",8,2)->nullable();
            // $table->string("tipopago")->nullable();
            $table->decimal("efectivo",8,2)->nullable();
            $table->decimal("debito",8,2)->nullable();
            $table->decimal("credito",8,2)->nullable();
            $table->decimal("cheque",8,2)->nullable();
            $table->decimal("cc",8,2)->nullable();
            $table->decimal("otro",8,2)->nullable();
            $table->decimal("vuelto",8,2)->nullable();
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
        Schema::dropIfExists('compras_detalle_pago');
    }
}
