<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVentasAddMontoRecibido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_ventas_add_monto_recibido --table=ventas
        Schema::table('ventas', function (Blueprint $table) {
            //
            $table->decimal("total_recibido",8,2)->default(0);

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
            $table->dropColumn('total_recibido');

        });
    }
}
