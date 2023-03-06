<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasdetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas_detalle', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('caja_id')->nullable();
            $table->bigInteger('user_id')->nullable(); // usuario que abrio la caja
            $table->date('inicio_fecha')->nullable();
            $table->time('inicio_hora')->nullable();
            $table->date('cierre_fecha')->nullable();
            $table->time('cierre_hora')->nullable();
            $table->decimal('monto_inicio')->default(0);
            $table->decimal('monto_estimado')->default(0);
            $table->decimal('monto_real')->default(0);
            $table->decimal('diferencia')->default(0);
            $table->decimal('ingresos')->default(0);
            $table->decimal('egresos')->default(0);
            $table->decimal('estado_cierre',1,0)->default(null); 
            // $table->string('estado')->nullable(); // justo, con faltante
            $table->boolean("caja_abierta")->default(false);
            $table->boolean("eliminado")->default(false);
            
            // $table->bigInteger('creator_id')->default(0);
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
        Schema::dropIfExists('cajas_detalle');
    }
}
