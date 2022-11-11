<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVentasDetallePagoAddPedidosya extends Migration
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
            // $table->decimal("pedidosya",8,2)->nullable();
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
            // $table->dropColumn('pedidosya');
        });
    }
}
