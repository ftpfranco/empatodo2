<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVentasAddTipoenvioId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //   php artisan make:migration alter_table_ventas_detalle_pago_add_tipopagoid --table=ventas_detalle_pago
        Schema::table('ventas', function (Blueprint $table) {
            //
            $table->bigInteger("tipoenvio_id")->nullable();

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
            $table->dropColumn('tipoenvio_id');

        });
    }
}
