<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal("cantidad_compras")->default(0);
            $table->decimal("cantidad_ventas")->default(0);
            $table->decimal("cantidad_ingresos")->default(0);
            $table->decimal("cantidad_egresos")->default(0);
            $table->decimal("monto_compras",8,2)->default(0);
            $table->decimal("monto_ventas",8,2)->default(0);
            $table->decimal("monto_ingresos",8,2)->default(0);
            $table->decimal("monto_egresos",8,2)->default(0);
            $table->decimal("mes",2,0)->default(0);
            $table->decimal("anio",4,0)->default(0);
            
            $table->bigInteger("user_id")->nullable();
            $table->bigInteger("creator_id")->nullable();

            $table->boolean("eliminado")->default(false);
            $table->timestamps();
            
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportes');
    }
}
