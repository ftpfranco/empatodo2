<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGastoEditComentario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('gasto', function (Blueprint $table) {
        //     //
        // });
        \DB::statement('ALTER TABLE public.gasto ALTER COLUMN comentario TYPE character varying(1000) COLLATE pg_catalog."default";');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // php artisan make:migration alter_table_ventas_add_monto_recibido --table=ventas
        // Schema::table('gasto', function (Blueprint $table) {
        //     //
        // });
    }
}
