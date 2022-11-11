<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVentasAddIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            //
            $table->index(['fecha']);

        });
        Schema::table('gasto', function (Blueprint $table) {
            //
            $table->index(['fecha']);

        });
        Schema::table('ingreso', function (Blueprint $table) {
            //
            $table->index(['fecha']);

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
        });
    }
}
