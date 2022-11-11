<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVentasDetallePagoAddTipopagoid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas_detalle_pago', function (Blueprint $table) {
            //
            $table->bigInteger("tipopago_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ventas_detalle_pago', function (Blueprint $table) {
            //
            $table->dropColumn('tipopago_id');


        });
    }
}
