<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePermissionAddDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_ventas_add_monto_recibido --table=ventas
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->string('description')->nullable() ->after("name");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->dropColumn('description');

        });
    }
}
