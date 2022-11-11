<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGastoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gasto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gastotipo_id')->nullable();
            
            $table->date('fecha')->nullable();
            $table->decimal("monto",8,0)->default(0);
            $table->text("comentario",2000)->nullable();
            
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('gasto');
    }
}
