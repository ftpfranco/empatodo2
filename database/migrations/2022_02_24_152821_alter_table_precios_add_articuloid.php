<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePreciosAddArticuloid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_precios_add_articuloid --table=precios
        Schema::table('precios', function (Blueprint $table) {
            //
            $table->bigInteger("articulo_id")->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('precios', function (Blueprint $table) {
            //
            $table->dropColumn('articulo_id');

        });
    }
}
