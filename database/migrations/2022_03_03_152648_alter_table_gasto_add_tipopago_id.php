<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGastoAddTipopagoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gasto', function (Blueprint $table) {
            //
            $table->bigInteger("tipopago_id")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gasto', function (Blueprint $table) {
            //
            $table->dropColumn('tipopago_id');

        });
    }
}
