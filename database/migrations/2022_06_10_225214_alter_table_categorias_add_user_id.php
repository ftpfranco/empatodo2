<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCategoriasAddUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_ventas_add_monto_recibido --table=ventas
        Schema::table('categorias', function (Blueprint $table) {
            //
            $table->bigInteger("user_id")->nullable()->after("categoria");
            // $table->bigInteger('creator_id')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorias', function (Blueprint $table) {
            //
            $table->dropColumn('user_id');
            // $table->bigInteger('creator_id')->default(0);

        });
    }
}
