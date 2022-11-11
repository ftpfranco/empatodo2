<?php

use App\Cajas;
use App\Cliente;
use App\Empresa;
use App\TipoPago;
use App\GastoTipo;
use App\Proveedor;
use App\TipoIdentificacion;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

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
        $permission->assignRole($role);
        $permission->assignRole($role_v);
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
        $permission->assignRole($role_v);
        $permission->assignRole($role);
        $permission = Permission::create(['name' => 'notificacion-destroy']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        $permission->assignRole($role_v);


        // PERMISOS REPORTES
        $permission = Permission::create(['name' => 'reportes-index']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);



        Cajas::create(['caja' => "Principal", 'habilitado' => true, 'eliminado' => false]);


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

        $df = GastoTipo::create(["gastotipo" => "Sueldo"]);


        $user = App\User::create([
            'nombre' => "franco",
            'email' => "francos@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt("francos"), // password
            'remember_token' => Str::random(10),
            "es_empleado" => false,
        ]);
        // App\User::where('id', $user->id)->update(['creator_id' => $user->id]);
        $user->assignRole('administrador');


       

        Empresa::create(["nombre" => "franco", "email" => "francos@gmail.com", "user_id" => $user->id]);

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


        
        Cliente::create([
            "nombre" => "Consumidor Final",
        ]);
        Proveedor::create([
            "nombre" => "Sin proveedor",
        ]);

        
    }
}
