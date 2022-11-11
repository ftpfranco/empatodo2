<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloVendidosPorDiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_vendidos_por_dia', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('articulo_id')->nullable();
            $table->string('articulo',200)->nullable();
            $table->decimal('cantidad',8,0)->default(0);
            $table->decimal("anio",4,0)->default(0);
            $table->decimal("mes",2,0)->default(0);
            $table->decimal("dia",2,0)->default(0)->index();
            // $table->time("hora")->default(0)->index();
            $table->boolean("t1")->nullable(); // turno 1
            $table->boolean("t2")->nullable(); // turno 2
            
            $table->boolean("habilitado")->default(true);
            $table->boolean("eliminado")->default(false);
            
            $table->bigInteger('creator_id')->default(0);
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
        Schema::dropIfExists('articulos_vendidos_por_dia');
    }
}
