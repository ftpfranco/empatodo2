<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVentasAddTipopagoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_compras_detalle_pago_add_tipopagoid_monto --table=compras_detalle_pago
        Schema::table('ventas', function (Blueprint $table) {
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
        Schema::table('ventas', function (Blueprint $table) {
            //
            $table->dropColumn('tipopago_id');

        });
    }
}
