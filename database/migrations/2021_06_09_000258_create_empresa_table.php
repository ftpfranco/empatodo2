<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            // 'id','nombre','cuit','email','telefono','whatsapp','provincia','localidad','direccion','creator_id','habilitado','eliminado','created_at','updated_at'

            $table->string("nombre")->nullable();
            $table->string("cuit")->nullable();
            $table->string("email")->nullable();
            $table->string("telefono")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("provincia")->nullable();
            $table->string("localidad")->nullable();
            $table->string("direccion")->nullable();


            $table->string("path_image")->nullable(); // logo para comprobantes
            $table->string("path_thumbnail")->nullable();
            
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
        Schema::dropIfExists('empresa');
    }
}
