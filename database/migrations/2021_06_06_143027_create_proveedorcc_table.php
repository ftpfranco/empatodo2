<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorccTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor_cc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('monto',8,2)->default(0);
            $table->bigInteger('proveedor_id')->nullable();
            $table->bigInteger('creator_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->boolean("eliminado")->default(false);

        //     'id','cliente_id','tipopago_id','es_ingreso','monto','fecha','comentario','puede_eliminar',
        // 'eliminado',"venta_id",'user_id','creator_id','created_at','updated_at'

      
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
        Schema::dropIfExists('proveedor_cc');
    }
}
