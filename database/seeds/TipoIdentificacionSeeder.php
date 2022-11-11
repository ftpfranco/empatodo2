<?php

use App\TipoIdentificacion;
use Illuminate\Database\Seeder;

class TipoIdentificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        TipoIdentificacion::create(["tipo_identificacion"=>"Cuit"]);
        TipoIdentificacion::create(["tipo_identificacion"=>"Cuil"]);
        TipoIdentificacion::create(["tipo_identificacion"=>"CDI"]);
        TipoIdentificacion::create(["tipo_identificacion"=>"LE"]);
        TipoIdentificacion::create(["tipo_identificacion"=>"LC"]);
        TipoIdentificacion::create(["tipo_identificacion"=>"CI extranjero"]);
        TipoIdentificacion::create(["tipo_identificacion"=>"Pasaporte"]);
    }
}
