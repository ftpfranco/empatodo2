<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // movimiento de cuenta corriente
        Schema::create('movimientos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger("cliente_id")->nullable();
            $table->bigInteger("user_id")->nullable();
            $table->bigInteger("tipopago_id")->nullable();
            $table->bigInteger("venta_id")->nullable(); // si el moviento es de una venta registrar id de venta
            $table->boolean("es_ingreso")->nullable(); // true ingreso, false deuda
            
            $table->decimal("monto",8,2)->nullable();
            $table->date("fecha")->nullable();

            $table->text("comentario")->nullable();
            $table->boolean("eliminado")->default(false);
            $table->boolean("puede_eliminar")->default(false);
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
        Schema::dropIfExists('movimientos');
    }
}
