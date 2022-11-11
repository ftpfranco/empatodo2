<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->nullable(); //->unique();
            
            $table->string("nombre")->nullable();
            $table->string("nombre_fantasia")->nullable();
            
            $table->bigInteger("tipo_identificacion_id")->nullable();
            $table->string("nro_dni")->nullable();
            $table->string("telefono")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("direccion")->nullable();
            $table->string("localidad")->nullable();
            $table->string("calle")->nullable();
            $table->string("nro_calle")->nullable();
            $table->string("piso")->nullable();
            $table->string("path_image")->nullable();
            $table->string("path_thumbnail")->nullable();

            $table->boolean("es_empleado")->default(true); 
            $table->boolean("habilitado")->default(true); 
            $table->boolean("eliminado")->default(0); 
 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
