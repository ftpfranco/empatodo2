<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('articulo')->nullable();
            $table->string('codigo')->nullable();
            $table->string('codigo_barras')->nullable();
            $table->decimal('stock',8,0)->default(0);
            $table->decimal('stock_minimo',8,0)->nullable();
            $table->decimal('precio_compra',8,2)->nullable();
            $table->decimal('precio_venta',8,2)->nullable();
            $table->decimal('precio_neto_venta',8,2)->nullable();

            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('marca_id')->nullable();
            $table->bigInteger('categoria_id')->nullable();
            $table->bigInteger('subcategoria_id')->nullable();
            $table->bigInteger('precio_id')->nullable();
            $table->bigInteger('tasa_iva_id')->default(1);
            
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
        Schema::dropIfExists('articulos');
    }
}
