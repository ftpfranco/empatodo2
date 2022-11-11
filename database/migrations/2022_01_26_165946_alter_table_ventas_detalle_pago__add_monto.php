<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVentasDetallePagoAddMonto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //   php artisan make:migration alter_table_ventas_detalle_pago_add_tipopagoid --table=ventas_detalle_pago
        // Schema::table('ventas_detalle_pago', function (Blueprint $table) {
        //     //

        //     $table->decimal("monto",8,2)->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('ventas_detalle_pago', function (Blueprint $table) {
        //     //
        //     $table->dropColumn("monto");
        // });
    }
}
