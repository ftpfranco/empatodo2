<?php

use App\User;
use App\Cajas;
use App\Gasto;
use App\Marca;
use App\Turno;
use App\Ventas;
use App\Cliente;
use App\Empresa;
use App\Ingreso;
use App\Articulo;
use App\Reportes;
use App\TipoPago;
use App\ClienteCC;
use App\GastoTipo;
use App\Proveedor;
use App\Categorias;
use App\IngresoTipo;
use App\ProveedorCC;
use App\CajasDetalle;
use App\Notificacion;
use App\ClienteCCPago;
use App\ProveedorCCPago;
use App\VentaDetallePago;
use App\TipoIdentificacion;
use Faker\Factory as Faker;
use App\VentaDetalleArticulo;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
 
    public function run(){
        App\User::where("es_empleado",false)->where("email","administrador@empatodo.com")->update([
            'password' => bcrypt("@17Empatodo"), // password
        ]);
    }
    
    public function run6()
    {
        // ver-estadisticas-articulos
        // ver-estadisticas 

        $vend = Role::where("name", "vendedor")->first();
        $admin = Role::where("name", "administrador")->first();

        $ver  = Permission::create(['name' => 'ver-estadisticas-articulos',"description"=> "Ver estadisticas de articulos"]);
       
        $admin->givePermissionTo($ver);

        $permission = Permission::create(['name' => 'ver-estadisticas',"description"=> "Ver estadisticas"]);
        $admin->givePermissionTo($permission);

        $permissions =  Permission::all();
        $admin->syncPermissions($permissions);


        $perm = Permission::whereIn("id",[  
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            98,
            53,
            54,
            55,
            56,
            57,
            58,
            59,
            60,
            89,
            90,
            35,
            36,
            37,
            38,
            40,
            41,
            42,
            43,
            99,
            71,
            72
        ])->get();
        $vend->syncPermissions($perm);
        $vend->givePermissionTo($ver);
    }

    public function run5()
    {
        //     articulo-index
        // articulo-filtro
        // articulo-editar-stock

        $vend = Role::where("name", "vendedor")->first();
        $permission = Permission::create(['name' => 'articulo-editar-stock',"description"=> "Editar stock"]);
        $vend->givePermissionTo($permission);

        $admin = Role::where("name", "administrador")->first();
        $admin->givePermissionTo($permission);

        $permissions =  Permission::all();
        $admin->syncPermissions($permissions);

        $permission = Permission::select('*')->where('name', 'articulo-index')->first();
        $vend->givePermissionTo($permission);

        $permission = Permission::where('name', 'articulo-filtro')->first();
        $vend->givePermissionTo($permission);

    }

    public function run1()
    {
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

    public function run4()
    {

        $vend = Role::where("name", "vendedor")->first();
        $vend->revokePermissionTo('egresos-destroy');
        $permission1 = Permission::create(['name' => 'ver.roles',"description"=>"Ver roles"]);
        $permission2 = Permission::create(['name' => 'agregar.roles',"description"=>"Agregar roles"]);
        $permission3 = Permission::create(['name' => 'editar.roles',"description"=>"Editar roles"]);
        $permission4 = Permission::create(['name' => 'eliminar.roles',"description"=>"Eliminar roles"]);
        
        $permission5 = Permission::create(['name' => 'ver.estadisticas',"description"=>"Ver estadisticas"]);
        $vend->givePermissionTo($permission5);

        $admin = Role::where("name","administrador")->first();
        $admin->givePermissionTo($permission5);
        
        $permissions =  Permission::all();
        $admin->syncPermissions($permissions);

        $permission = Permission::select('*')->where('name', 'egresos-index')->first();
        $vend->givePermissionTo($permission);

        $permission = Permission::where('name','egresos-store')->first();
        $vend->givePermissionTo($permission);

        $permission = Permission::where('name','egresos-editar')->first();
        $vend->givePermissionTo($permission);

        $permission = Permission::where('name','egresos-filtro')->first();
        $vend->givePermissionTo($permission);

        $permission = Permission::where('name','egresos-destroy')->first();
        $vend->givePermissionTo($permission);

        // PERMISOS EGRESOS TIPO
        $permission = Permission::where('name','tipoe-index')->first();
        $vend->givePermissionTo($permission);
        $permission = Permission::where('name','tipoe-store')->first();
        $vend->givePermissionTo($permission);
        $permission = Permission::where('name','tipoe-editar')->first();
        $vend->givePermissionTo($permission);
        $permission = Permission::where('name','tipoe-destroy')->first();
        $vend->givePermissionTo($permission);


     }

    public function run3()
    {
        //   ejecutar esto para limpiar cache de spatie
        // php artisan permission:cache-reset

        $vend = Role::where("name","vendedor")->first();
        $admin = Role::where("name","administrador")->first();
        $permission1 = Permission::create(['name' => 'venta-listado']);
        $permission2 = Permission::create(['name' => 'venta-pago-destroy']);

        $vend->givePermissionTo($permission2);
        $admin->givePermissionTo($permission1);
        $admin->givePermissionTo($permission2);

        $permission1->assignRole($admin);
        $permission2->assignRole($admin);
        $permission2->assignRole($vend);

        $vend->revokePermissionTo('venta-destroy');
        $vend->revokePermissionTo('caja-destroy');
        $vend->revokePermissionTo('venta-pago-destroy');


        $users = User::select("id")->where("es_empleado",false)->get();
        $time1_start = "07:30";
        $time1_end = "16:00";

        $time2_start = "16:01";
        $time2_end = "23:59";
        foreach ($users as $key => $value) {
            # code...
            Turno::create([
                "time1_start" => $time1_start,
                "time1_end" => $time1_end,
                "time2_start" => $time2_start,
                "time2_end" => $time2_end,
                "user_id" => $value["id"],
            ]);
        }

        $user = App\User::where("es_empleado",false)->where("email","administrador@gmail.com")->update([
            'email' => "administrador@empatodo.com",
            'password' => bcrypt("empatodo!123"), // password
        ]);

        

     }


    public function run2()
    {

        $role_v = Role::create(['name' => 'vendedor']);
        $role = Role::create(['name' => 'administrador']);

        $permission = Permission::create(['name' => 'caja-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-abrir']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-cerrar']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-ingreso']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-egreso']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-update']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-show']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'caja-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);

        // PERMISOS CLIENTES
        $permission = Permission::create(['name' => 'cliente-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'cliente-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'cliente-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'cliente-update']);
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'cliente-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        // PERMISOS CUENTA CORRIENTE
        $permission = Permission::create(['name' => 'cccliente-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'cccliente-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'cccliente-pago']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'cccliente-detalle']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'cccliente-ingresarpago']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        // PERMISOS EMPLEADOS
        $permission = Permission::create(['name' => 'empleado-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'empleado-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'empleado-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'empleado-update']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'empleado-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);


        // PERMISOS PROVEEDORES
        $permission = Permission::create(['name' => 'proveedor-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'proveedor-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'proveedor-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'proveedor-update']);
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'proveedor-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        // PERMISOS PROVEEDORES CUENTA CORRIENTE
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'ccproveedor-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'ccproveedor-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'ccproveedor-detalle']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'ccproveedor-ingresarpago']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);


        // PERMISOS EGRESOS
        $permission = Permission::create(['name' => 'egresos-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'egresos-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'egresos-editar']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'egresos-filtro']);
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'egresos-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        // PERMISOS EGRESOS TIPO
        $permission = Permission::create(['name' => 'tipoe-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'tipoe-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'tipoe-editar']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'tipoe-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);



        // PERMISOS INGRESOS
        $permission = Permission::create(['name' => 'ingreso-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'ingreso-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'ingreso-editar']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'ingreso-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'ingreso-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        // PERMISOS INGRESOS TIPO
        $permission = Permission::create(['name' => 'tipoi-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'tipoi-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'tipoi-editar']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'tipoi-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);



        // PERMISOS VENTAS
        $permission = Permission::create(['name' => 'venta-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'venta-edit']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'venta-show']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'venta-update']);
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'venta-comprobante']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'venta-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'venta-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'venta-nuevo']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);
        $permission = Permission::create(['name' => 'venta-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);

        // PERMISOS COMPRAS
        $permission = Permission::create(['name' => 'compra-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'compra-edit']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'compra-show']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'compra-update']);
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'compra-comprobante']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'compra-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'compra-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'compra-nuevo']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'compra-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        // PERMISOS ARTICULOS
        $permission = Permission::create(['name' => 'articulo-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'articulo-filtro']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'articulo-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'articulo-edit']);
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'articulo-editar']);
        $role->givePermissionTo($permission);
        $permission = Permission::create(['name' => 'articulo-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        // $permission = Permission::create(['name' => 'articulo-']);
        // $role->givePermissionTo($permission);
        // $permission->assignRole($role);

        // PERMISOS CATEGORIAS
        $permission = Permission::create(['name' => 'categoria-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'categoria-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'categoria-edit']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'categoria-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);


        // PERMISOS MARCA 
        $permission = Permission::create(['name' => 'marca-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'marca-store']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'marca-edit']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'marca-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);


        // PERMISOS EMPRESA 
        $permission = Permission::create(['name' => 'empresa-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'empresa-update']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'empresa-logoventas']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'empresa-logoprofile']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);



        // PERMISOS NOTIFICACIONES
        $permission = Permission::create(['name' => 'notificacion-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'notificacion-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);


        // PERMISOS REPORTES
        $permission = Permission::create(['name' => 'reportes-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);


        $user = App\User::create([
            'nombre' => "administrador",
            'email' => "administrador@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt("administrador"), // password
            'remember_token' => Str::random(10),
            "es_empleado" => false,
        ]);
        // App\User::where('id', $user->id)->update(['creator_id' => $user->id]);
        $user->assignRole('administrador');


        // Empresa::create(["nombre" => "franco", "email" => "francos@gmail.com", "user_id" => $user->id]);


        // for ($i = 0; $i < 25; $i++) {
        //     $faker = Faker::create();
        //     $email =  $faker->email;
        //     $user = App\User::create([
        //         'nombre' => $faker->name,
        //         'tipo_identificacion_id' => rand(1, 5),
        //         'es_empleado' => rand(0, 1),
        //         'habilitado' => rand(0, 1),
        //         'telefono' => $faker->e164PhoneNumber,
        //         'email' => $email,
        //         'email_verified_at' => now(),
        //         'password' =>  bcrypt($email), // password
        //         'remember_token' => Str::random(10),
        //         "es_empleado" => true
        //     ]);
        //     $user->assignRole('vendedor');
        // }


        // Cajas::create(['caja' => "Principal", 'habilitado' => true, 'eliminado' => false]);

        // for ($i = 0; $i < 20; $i++) {
        //     $faker = Faker::create();
        //     CajasDetalle::create([
        //         'caja_id' => 1, 'user_id' => 1,
        //         'inicio_fecha' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //         'inicio_hora' =>  date("H:m"),  // $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //         'cierre_fecha' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //         'cierre_hora' => date("H:m"), //$faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //         'monto_inicio' =>  $faker->numberBetween($min = 1000, $max = 9000),
        //         'monto_estimado' => $faker->numberBetween($min = 2000, $max = 4400),
        //         'monto_real' => $faker->numberBetween($min = 9000, $max = 100000),
        //         'diferencia' => $faker->numberBetween($min = -1000, $max = 2000),
        //         'ingresos' => $faker->numberBetween($min = 100, $max = 900),
        //         'egresos' => $faker->numberBetween($min = 100, $max = 900),
        //         "caja_abierta" => false
        //     ]);
        // }
        // $this->call(TipoIdentificacionSeeder::class);

        TipoIdentificacion::create(["tipo_identificacion" => "Cuit"]);
        TipoIdentificacion::create(["tipo_identificacion" => "Cuil"]);
        TipoIdentificacion::create(["tipo_identificacion" => "CDI"]);
        TipoIdentificacion::create(["tipo_identificacion" => "LE"]);
        TipoIdentificacion::create(["tipo_identificacion" => "LC"]);
        TipoIdentificacion::create(["tipo_identificacion" => "CI extranjero"]);
        TipoIdentificacion::create(["tipo_identificacion" => "Pasaporte"]);

        TipoPago::create(['tipo_pago' => 'Efectivo']);
        TipoPago::create(['tipo_pago' => "Tarjeta Debito"]);
        TipoPago::create(['tipo_pago' => "Tarjeta Credito"]);
        TipoPago::create(['tipo_pago' => "Cheque"]);
        TipoPago::create(['tipo_pago' => "Cuenta corriente"]);
        TipoPago::create(['tipo_pago' => "Otro"]);


        // Cliente::create([
        //     "nombre" => "Consumidor Final",
        // ]);

        // for ($i = 0; $i < 30; $i++) {
        //     $faker = Faker::create();
        //     Cliente::create([
        //         'nombre' => $faker->name, 'email' => $faker->email,
        //         'tipo_identificacion_id' => rand(1, 5),
        //         'telefono' => $faker->e164PhoneNumber

        //     ]);
        // }

        //marcas 
        // for ($i = 0; $i < 10; $i++) {
        //     Marca::create([
        //         "marca" => $faker->text(10),
        //     ]);

        //     Categorias::create([
        //         "categoria" => $faker->text(10),
        //     ]);
        // }
        // productos 
        // for ($i = 0; $i < 10; $i++) {
        //     $faker = Faker::create();
        //     $precio_compra = $faker->numberBetween($min = 10, $max = 9000);
        //     $precio_venta = $precio_compra + 30;
        //     $precio_neto_venta = $precio_venta;
        //     $stock = $faker->numberBetween($min = 1000, $max = 3000);
        //     $stock_minimo = $faker->numberBetween($min = 100, $max = 800);
        //     $creator_id = 1;

        //     $precio_id = \DB::table('precios')->insertGetId(
        //         array(
        //             "precio_compra" => $precio_compra,
        //             "precio_venta" => $precio_venta,
        //             "precio_neto_venta" => $precio_neto_venta,
        //             "creator_id" => $creator_id
        //         )
        //     );

        //     Articulo::create([
        //         "articulo" => $faker->text(10),
        //         "codigo" => $faker->ean13,
        //         "codigo_barras" => $faker->ean13,
        //         "stock" => $stock,
        //         "stock_minimo" => $stock_minimo,
        //         "precio_compra" => $precio_compra,
        //         "precio_venta" => $precio_venta,
        //         "precio_neto_venta" => $precio_neto_venta,
        //         "user_id" => 1,
        //         "marca_id" => rand(1, 10),
        //         "categoria_id" => rand(1, 10),
        //         "subcategoria_id" => 0,
        //         "precio_id" => $precio_id,
        //         "creator_id" => $creator_id
        //     ]);
        // } // for







        // clientes 
        // for ($i = 0; $i < 20; $i++) {

        //     //     'id','nombre','email','tipo_identificacion_id','nro_dni','telefono',
        //     // 'localidad','direccion','calle','nro_calle','piso','eliminado','tiene_ccorriente','creator_id',
        //     // 'comentario',
        //     // 'created_at','updated_at'
        //     $cliente = Cliente::create([
        //         "nombre" => $faker->name,
        //         "email" => $faker->email,
        //         'telefono' => $faker->e164PhoneNumber

        //     ]);

        //     // 'id','cliente_id','monto','fecha', 'eliminado','user_id','creator_id','created_at','updated_at'
        //     $cc = ClienteCC::create([
        //         "cliente_id" => $cliente->id,
        //         "monto" => rand(20, 5000),
        //         "user_id" => 1,
        //     ]);

        //     for ($i = 0; $i < 20; $i++) {
        //         // 'id','cliente_id','tipopago_id',"fecha",'monto', 'eliminado','user_id','creator_id','created_at','updated_at'
        //         ClienteCCPago::create([
        //             "cliente_id" => $cc->id,
        //             "monto" => rand(10, 100),
        //             "fecha" => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //         ]);
        //         # code...
        //     }
        // }



        
        // Proveedor::create([
        //     "nombre" => "Sin proveedor",
        // ]);

        // proveedor 
        // for ($i = 0; $i < 20; $i++) {
        //     $faker = Faker::create();
        //     //     'id','nombre','email','tipo_identificacion_id','nro_dni','telefono',
        //     // 'localidad','direccion','calle','nro_calle','piso','eliminado','tiene_ccorriente','creator_id',
        //     // 'comentario',
        //     // 'created_at','updated_at'
        //     $cliente = Proveedor::create([
        //         "nombre" => $faker->name,
        //         "email" => $faker->email,
        //         'telefono' => $faker->e164PhoneNumber

        //     ]);

        //     // 'id','cliente_id','monto','fecha', 'eliminado','user_id','creator_id','created_at','updated_at'
        //     // $cc = ProveedorCC::create([
        //     //     "proveedor_id" => $cliente->id,
        //     //     "monto" => rand(20, 5000),
        //     //     "user_id" => 1,
        //     // ]);

        //     // for ($j = 0; $j < 20; $j++) {
        //     //     // 'id','cliente_id','tipopago_id',"fecha",'monto', 'eliminado','user_id','creator_id','created_at','updated_at'
        //     //     ProveedorCCPago::create([
        //     //         "proveedor_id" => $cc->id,
        //     //         "monto" => rand(10, 100),
        //     //         "fecha" => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //     //     ]);
        //     //     # code...
        //     // }
        // }


        // tipos gastos 
        // for ($i = 0; $i < 10; $i++) {
        //     $df = GastoTipo::create(["gastotipo" => $faker->text(10)]);
        //     $df = IngresoTipo::create(["ingresotipo" => $faker->text(10)]);
        // }

        // gastos
        // for ($i = 0; $i < 19; $i++) {
        //     # code...
        //     // 'id','gastotipo_id','comentario','monto','fecha','user_id','creator_id','eliminado','created_at','updated_at'
        //     $text = rand(10, 100);
        //     Gasto::create([
        //         "gastotipo_id" => rand(1, 10),
        //         "comentario" => $faker->text($text),
        //         "fecha" => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //         "monto" => rand(10, 5000),
        //     ]);
        //     Ingreso::create([
        //         "ingresotipo_id" => rand(1, 10),
        //         "comentario" => $faker->text($text),
        //         "fecha" => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //         "monto" => rand(10, 5000),
        //     ]);
        // }






        // ventas 
        // for ($i = 0; $i < 50; $i++) {
        //     $faker = Faker::create();
        //     $monto = $faker->numberBetween($min = 100, $max = 9999);
        //     Ventas::create([
        //         "user_id" => $faker->numberBetween($min = 1, $max = 10),
        //         "fecha" => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        //         "hora" => date('H:m'),
        //         "monto" => $monto,
        //         "cliente_id" =>  $faker->numberBetween($min = 1, $max = 10),
        //         "pago_completo" => rand(0, 1),
        //         "descuento_porcentaje" => rand(1, 100),
        //         "descuento_importe" => rand(1, 100)
        //     ]);

        //     for ($j = 0; $j < 5; $j++) {
        //         # code...
        //         VentaDetalleArticulo::create([
        //             'venta_id' => rand(1, 50),
        //             'articulo_id' => rand(1, 20),
        //             'articulo' => $faker->text(50),
        //             'cantidad' => rand(1, 10),
        //             "descuento" => rand(1, 100),
        //             "precio" => rand(1, 100),
        //             'subtotal' => rand(1, 200), "comentario" => $faker->text(10)
        //         ]);
        //     }
        //     VentaDetallePago::create([
        //         "efectivo" => $faker->numberBetween($min = 10, $max = 5000),
        //         "debito" => $faker->numberBetween($min = 10, $max = 5000),
        //         "credito" => $faker->numberBetween($min = 10, $max = 5000),
        //         "cheque" => $faker->numberBetween($min = 10, $max = 5000),
        //         "cc" => $faker->numberBetween($min = 10, $max = 5000),
        //         "otro" => $faker->numberBetween($min = 10, $max = 5000),
        //         "vuelto" => $faker->numberBetween($min = 10, $max = 5000),
        //         "venta_id" => rand(1, 50)
        //     ]);
        // }



        // for ($i = 0; $i < 40; $i++) {
        //     # code...
        //     Notificacion::create([
        //         "descripcion" =>  $faker->text(rand(10, 100)),
        //         "user_id" => 1,
        //         "articulo_id" => rand(1, 100)
        //     ]);
        //     Notificacion::create([
        //         "descripcion" =>  "El articulo " . $faker->text(rand(105, 30)) . " se esta quedando sin stock.!",
        //         "user_id" => 1,
        //         "articulo_id" => rand(1, 100)
        //     ]);
        // }




        // for($i=1;$i<=12; $i++){

        //     Reportes::create([
        //         "cantidad_compras"=> rand(10,100),
        //         "cantidad_ventas"=> rand(10,100),
        //         "cantidad_ingresos"=> rand(10,100),
        //         "cantidad_egresos"=> rand(10,100),
        //         "monto_compras"=> rand(100,10000),
        //         "monto_ventas"=> rand(100,10000),
        //         "monto_ingresos"=> rand(100,10000),
        //         "monto_egresos"=> rand(100,10000),
        //         "mes"=> $i,
        //         "anio"=>date("Y")
        //     ]);
        // }





    }
}
