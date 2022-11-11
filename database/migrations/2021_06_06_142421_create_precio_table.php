<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('precio_neto_venta',8,2)->nullable();
            $table->decimal('precio_compra',8,2)->nullable();
            $table->decimal('precio_venta',8,2)->nullable();
            $table->decimal('precio_descuento_porc',8,2)->nullable();
            $table->decimal('precio_descuento_impor',8,2)->nullable();
            $table->boolean('eliminado')->default(false);

            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('precios');
    }
}
