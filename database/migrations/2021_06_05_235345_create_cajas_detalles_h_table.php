<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasDetallesHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas_detalle_h', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('cajadetalle_id')->nullable();
            $table->date('inicio_fecha')->nullable();
            $table->time('inicio_hora')->nullable();
            $table->date('cierre_fecha')->nullable();
            $table->time('cierre_hora')->nullable();
            $table->decimal('monto_inicio')->default(0);
            $table->decimal('monto_estimado')->default(0);
            $table->decimal('monto_real')->default(0);
            $table->decimal('diferencia')->default(0);
            // $table->decimal('estado_cierre',1,0)->default(null); 
            $table->string('estado',30)->nullable();  
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
        Schema::dropIfExists('cajas_detalle_h');
    }
}
