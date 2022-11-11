<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableArticulosAddDescripcion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_reportes_add_index --table=reportes

        Schema::table('articulos', function (Blueprint $table) {
            //
            $table->string("nombre_corto",30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropColumn('nombre_corto');
            //
        });
    }
}
