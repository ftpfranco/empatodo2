<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorccPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor_cc_pago', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('monto',8,2)->default(0);
            $table->decimal('monto_anterior',8,2)->default(0);
            $table->date('fecha')->nullable();
            $table->bigInteger('proveedor_id')->nullable();
            $table->bigInteger('tipopago_id')->nullable();
            $table->bigInteger('creator_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            // $table->bigInteger('tipopago_id')->nullable();
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
        Schema::dropIfExists('proveedor_cc_pago');
    }
}
