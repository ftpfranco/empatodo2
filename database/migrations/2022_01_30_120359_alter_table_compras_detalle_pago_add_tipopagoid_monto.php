<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableComprasDetallePagoAddTipopagoidMonto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_compras_detalle_pago_add_tipopagoid_monto --table=compras_detalle_pago
        Schema::table('compras_detalle_pago', function (Blueprint $table) {
            //
            $table->decimal("monto",8,2)->nullable();
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
        Schema::table('compras_detalle_pago', function (Blueprint $table) {
            //
            $table->dropColumn('tipopago_id');
            $table->dropColumn("monto");

        });
    }
}
