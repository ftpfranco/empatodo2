<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableReportesAddIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // php artisan make:migration alter_table_reportes_add_index --table=reportes
        Schema::table('reportes', function (Blueprint $table) {
            //
            $table->index(["mes",'anio']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reportes', function (Blueprint $table) {
            //
        });
    }
}
