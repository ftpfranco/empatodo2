<?php

use App\TipoPago;
use Illuminate\Database\Seeder;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoPago::create(["tipo_pago"=>"Pedidos Ya"]);
    }
}
