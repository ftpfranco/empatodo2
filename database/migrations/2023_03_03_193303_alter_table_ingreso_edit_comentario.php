<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableIngresoEditComentario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_ventas_add_monto_recibido --table=ventas

        // Schema::table('ingreso', function (Blueprint $table) {
        //     //
        // });
        \DB::statement('ALTER TABLE public.ingreso ALTER COLUMN comentario TYPE character varying(1000) COLLATE pg_catalog."default";');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('ingreso', function (Blueprint $table) {
        //     //
        // });
    }
}
