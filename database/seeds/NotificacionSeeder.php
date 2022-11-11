<?php

use App\Notificacion;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class NotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        for($i=1;$i<=12;$i++){
            Notificacion::create([
                "articulo_id"=>rand(1,100),
                "descripcion"=>   $faker->text(rand(10,50)),
            ]);
        }
    }
}
