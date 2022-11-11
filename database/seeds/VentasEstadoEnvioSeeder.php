<?php

use App\VentasEstadoEnvio;
use Illuminate\Database\Seeder;

class VentasEstadoEnvioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        VentasEstadoEnvio::create(["nombre"=>"Ordenado"]);
        VentasEstadoEnvio::create(["nombre"=>"En preparacion"]);
        VentasEstadoEnvio::create(["nombre"=>"Enviado"]);
        VentasEstadoEnvio::create(["nombre"=>"Cancelado"]);
    }
}
