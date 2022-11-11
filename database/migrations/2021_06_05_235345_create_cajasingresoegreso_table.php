<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasingresoegresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas_mov', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('cajadetalle_id')->nullable();
            $table->bigInteger('user_id')->nullable(); // usuario que abrio la caja
            $table->decimal('monto')->nullable();
            $table->boolean("es_ingreso")->nullable();
            $table->string('comentario',2000)->nullable();
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
        Schema::dropIfExists('cajas_mov');
    }
}
