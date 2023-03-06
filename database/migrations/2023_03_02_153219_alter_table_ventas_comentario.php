<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVentasComentario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_ventas_add_monto_recibido --table=ventas
        // Schema::table('ventas', function (Blueprint $table) {
        //     //
        //     $table->renameColumn('column', 'column');
        // });
        \DB::statement('ALTER TABLE public.ventas ALTER COLUMN comentario TYPE character varying(1000) COLLATE pg_catalog."default";');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('ventas', function (Blueprint $table) {
        //     //
        // });
    }
}
