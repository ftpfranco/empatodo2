<?php

use App\Precio;
use App\Articulo;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;


class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 'id','precio_neto_venta','precio_compra','precio_venta','precio_descuento_porc',
        // 'precio_descuento_impor','estado',
        // 'user_id','creator_id','eliminado','created_at','updated_at'


        for ($i = 0; $i < 10; $i++) {
            $faker = Faker::create();
            $precio_compra = $faker->numberBetween($min = 10, $max = 9000);
            $precio_venta = $precio_compra + 30;
            $precio_neto_venta = $precio_venta;
            $stock = $faker->numberBetween($min = 1000, $max = 3000);
            $stock_minimo = $faker->numberBetween($min = 100, $max = 800);
            $creator_id = 1;

            // $precio = new Precio([
            //     "precio_compra" => $precio_compra,
            //     "precio_venta" => $precio_venta,
            //     "precio_neto_venta" => $precio_neto_venta,
            //     "creator_id" => $creator_id
            // ]);

            $precio_id = \DB::table('precios')->insertGetId(
                array(
                    "precio_compra" => $precio_compra,
                    "precio_venta" => $precio_venta,
                    "precio_neto_venta" => $precio_neto_venta,
                    "creator_id" => $creator_id
                )
            );

            Articulo::create([
                "articulo" => $faker->text(10),
                "codigo" => $faker->ean13,
                "codigo_barras" => $faker->ean13,
                "stock" => $stock,
                "stock_minimo" => $stock_minimo,
                "precio_compra" => $precio_compra,
                "precio_venta" => $precio_venta,
                "precio_neto_venta" => $precio_neto_venta,
                "user_id" => 1,
                "marca_id" => 1,
                "categoria_id" => 1,
                "subcategoria_id" => 1,
                "precio_id" => $precio_id,
                "creator_id" => $creator_id
            ]);
        }
    }
}
