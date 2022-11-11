<?php

use App\Proveedor;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         // proveedor 
         for ($i = 0; $i < 20; $i++) {
            $faker = Faker::create();
            //     'id','nombre','email','tipo_identificacion_id','nro_dni','telefono',
            // 'localidad','direccion','calle','nro_calle','piso','eliminado','tiene_ccorriente','creator_id',
            // 'comentario',
            // 'created_at','updated_at'
            $cliente = Proveedor::create([
                "nombre" => $faker->name,
                "email" => $faker->email,
                'telefono' => $faker->e164PhoneNumber

            ]);

            // 'id','cliente_id','monto','fecha', 'eliminado','user_id','creator_id','created_at','updated_at'
            // $cc = ProveedorCC::create([
            //     "proveedor_id" => $cliente->id,
            //     "monto" => rand(20, 5000),
            //     "user_id" => 1,
            // ]);

            // for ($j = 0; $j < 20; $j++) {
            //     // 'id','cliente_id','tipopago_id',"fecha",'monto', 'eliminado','user_id','creator_id','created_at','updated_at'
            //     ProveedorCCPago::create([
            //         "proveedor_id" => $cc->id,
            //         "monto" => rand(10, 100),
            //         "fecha" => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
            //     ]);
            //     # code...
            // }
        }


    }
}
