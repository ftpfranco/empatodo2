<?php

use Pusher\Pusher;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get("login", "Auth\LoginController@showLoginForm")->name("login");
Route::post("login", "Auth\LoginController@login")->name("login");
Route::post("logout", "Auth\LoginController@logout")->name("logout");


Route::group(['middleware' => ['auth']], function () {

    // cajas
    Route::get("cajas", "CajasController@index")->middleware(["permission:caja-index"]); //->middleware(['role:premium1','permission:caja-cajas']);
    Route::get("cajas/filtro", "CajasController@filtro")->middleware(["permission:caja-filtro"]); //->middleware(['role:premium1','permission:caja-cajas']);
    Route::post("cajas", "CajasController@store")->middleware(["permission:caja-store"]);  //->middleware(['role:premium1', 'permission:store-cajas']);
    Route::post("cajas/abrir", "CajasController@abrir")->middleware(["permission:caja-abrir"]); //->middleware(['role:premium1','permission:store-cajas']);
    Route::post("cajas/cerrar", "CajasController@cerrar")->middleware(["permission:caja-cerrar"]);  //->middleware(['role:premium1','permission:store-cajas']);
    Route::post("cajas/ingreso", "CajasController@ingreso")->middleware(["permission:caja-ingreso"]); //->middleware(['role:premium1','permission:store-cajas']);
    Route::post("cajas/egreso", "CajasController@egreso")->middleware(["permission:caja-egreso"]);; //->middleware(['role:premium1','permission:store-cajas']);
    Route::put("cajas/update/{caja}", "CajasController@update")->middleware(["permission:caja-update"]);  //->middleware(['role:premium1', 'permission:update-cajas']);
    Route::get("cajas/show/{caja}", "CajasController@show")->middleware(["permission:caja-show"]);  //->middleware(['role:premium1', 'permission:show-cajas']);
    Route::delete("cajas/delete/{caja}", "CajasController@destroy")->middleware(["permission:caja-destroy"]);  //->middleware(['role:premium1', 'permission:delete-cajas']);



    // cliente
    // Route::get("clientes", "ClienteController@index")->middleware(['permission:cliente-index']);
    // Route::get("clientes/filtro", "ClienteController@filtro")->middleware(['permission:cliente-filtro']);
    // Route::post("clientes", "ClienteController@store")->middleware(['permission:cliente-store']);
    // Route::put("clientes/{id}/editar", "ClienteController@update")->middleware(['permission:cliente-update']);
    // Route::delete("clientes/{id}/delete", "ClienteController@destroy")->middleware(['permission:cliente-destroy']);


    // cuenta corriente
    // Route::get("clientecc", "ClienteCCController@index")->middleware(['permission:cccliente-index']);
    // Route::get("clientecc/filtro", "ClienteCCController@filtro")->middleware(['permission:cccliente-filtro']);
    // Route::post("clientecc/pago", "ClienteCCController@pago")->middleware(['permission:cccliente-pago']);
    // Route::get("clientecc/detalle/{id}", "ClienteCCController@detalle")->middleware(['permission:cccliente-detalle']);
    // Route::post("clientecc/detalle/{id}/ingresarpago", "ClienteCCController@ingresarpago")->middleware(['permission:cccliente-ingresarpago']);



    // empleados
    Route::get("empleados", "EmpleadoController@index")->middleware(['permission:empleado-index']);
    Route::get("empleados/filtro", "EmpleadoController@filtro")->middleware(['permission:empleado-filtro']);
    Route::post("empleados", "EmpleadoController@store")->middleware(['permission:empleado-update']);
    Route::put("empleados/{id}/editar", "EmpleadoController@update")->middleware(['permission:empleado-update']);
    Route::delete("empleados/{id}/delete", "EmpleadoController@destroy")->middleware(['permission:empleado-destroy']);
    
    Route::post("userhorarios", "TurnosController@index")->middleware(['permission:empleado-index']);



    // proveedores
    // Route::get("proveedores", "ProveedorController@index")->middleware(['permission:proveedor-index']);
    // Route::get("proveedores/filtro", "ProveedorController@filtro")->middleware(['permission:proveedor-index']);
    // Route::post("proveedores", "ProveedorController@store")->middleware(['permission:proveedor-store']);
    // Route::put("proveedores/{id}/editar", "ProveedorController@update")->middleware(['permission:proveedor-update']);
    // Route::delete("proveedores/{id}/delete", "ProveedorController@destroy")->middleware(['permission:proveedor-destroy']);

    // cuenta corriente
    // Route::get("proveedorcc", "ProveedorCCController@index")->middleware(['permission:ccproveedor-index']);
    // Route::get("proveedorcc/filtro", "ProveedorCCController@filtro")->middleware(['permission:ccproveedor-filtro']);
    // Route::get("proveedorcc/detalle/{id}", "ProveedorCCController@detalle")->middleware(['permission:ccproveedor-detalle']);
    // Route::post("proveedorcc/detalle/{id}/ingresarpago", "ProveedorCCController@ingresarpago")->middleware(['permission:ccproveedor-ingresarpago']);


    // egresos
    Route::get("egresos", "GastoController@index")->middleware(['permission:egresos-index']);
    Route::post("egresos", "GastoController@store")->middleware(['permission:egresos-store']);
    Route::put("egresos", "GastoController@editar")->middleware(['permission:egresos-editar']);
    Route::delete("egresos/{id}/delete", "GastoController@delete")->middleware(['permission:egresos-destroy']);
    Route::get("egresos/filtro", "GastoController@filtro")->middleware(['permission:egresos-filtro']);


    // egresos tipos
    Route::get("egresostipos", "GastoTipoController@index")->middleware(['permission:tipoe-index']);
    Route::post("egresostipos", "GastoTipoController@store")->middleware(['permission:tipoe-store']);
    Route::post("egresostipos/{id}/editar", "GastoTipoController@editar")->middleware(['permission:tipoe-editar']);
    Route::post("egresostipos/{id}/eliminar", "GastoTipoController@eliminar")->middleware(['permission:tipoe-destroy']);



    // ingresos
    Route::get("ingresos", "IngresosController@index")->middleware(['permission:ingreso-index']);
    Route::post("ingresos", "IngresosController@store")->middleware(['permission:ingreso-store']);
    Route::put("ingresos", "IngresosController@editar")->middleware(['permission:ingreso-editar']);
    Route::delete("ingresos/{id}/delete", "IngresosController@delete")->middleware(['permission:ingreso-destroy']);
    Route::get("ingresos/filtro", "IngresosController@filtro")->middleware(['permission:ingreso-filtro']);


    // ingresos tipos
    Route::get("ingresostipos", "IngresosTipoController@index")->middleware(['permission:tipoi-index']);
    Route::post("ingresostipos", "IngresosTipoController@store")->middleware(['permission:tipoi-store']);
    Route::put("ingresostipos/{id}/editar", "IngresosTipoController@editar")->middleware(['permission:tipoi-editar']);
    Route::delete("ingresostipos/{id}/eliminar", "IngresosTipoController@eliminar")->middleware(['permission:tipoi-destroy']);


    // ventas
    Route::get('listado', 'VentasController@listado')->name("listado")->middleware(['permission:venta-listado']);
    Route::get('listado/filtro', 'VentasController@filtroListado')->middleware(['permission:venta-listado']);
    Route::get('ventas-diarias', 'VentasController@index')->name("ventas")->middleware(['permission:venta-index']);
    Route::get('ventas/edit/{id}', 'VentasController@edit')->middleware(['permission:venta-edit']);
    Route::get('ventas/{id}/show', 'VentasController@show')->middleware(['permission:venta-show']);
    Route::put('ventas/enviado', 'VentasController@enviado')->middleware(['permission:venta-show']);
    Route::put('ventas/edit/{id}/update', 'VentasController@update')->middleware(['permission:venta-update']);
    Route::post('ventas/edit/{id}/comprobante', 'VentasController@comprobante')->middleware(['permission:venta-comprobante']);
    Route::get('ventas/filtro', 'VentasController@filtro')->middleware(['permission:venta-filtro']);
    Route::post('ventas/ventas', 'VentasController@store')->middleware(['permission:venta-store']);
    Route::get('ventas/nuevo', 'VentasController@nuevo')->middleware(['permission:venta-nuevo']);
    Route::delete('ventas/{id}/destroy', 'VentasController@destroy')->middleware(['permission:venta-destroy']);
    Route::delete('ventas-diarias/{id}/destroy', 'VentasController@destroy')->middleware(['permission:venta-destroy']);
    // Route::post('ventas/{venta_id}/articulos', 'VentasController@add_articulos');
    // Route::post('ventas/{venta_id}/pagos', 'VentasController@add_pagos');

    Route::delete('pagos/{id}/destroy', 'PagosController@destroy')->middleware(['permission:venta-pago-destroy']);


    // mostrador de pedidos pendientes
    Route::get('mostrador', 'MostradorController@index');
    Route::post('mostrador/editarpedido', 'MostradorController@editarpedido');
    // Route::get('mostrador/views', function () {

    //     $options = array(
    //         'cluster' => env("PUSHER_APP_CLUSTER"),
    //         'encrypted' => true
    //     );
    //     $pusher = new Pusher(
    //         env('PUSHER_APP_KEY'),
    //         env('PUSHER_APP_SECRET'),
    //         env('PUSHER_APP_ID'),
    //         $options
    //     );
    //     $data["venta_id"] = 3;
    //     $data['cliente'] = 'JUANITA LA METICHE';
    //     $data["created_at"] = date("Y-m-d H:i");
    //     $data["articulos"] = array(
    //         array(
    //             "cantidad" => 1,
    //             "articulo" => "EMPANADAS CEBOLLA Y QUESO",
    //         ),
    //         array(
    //             "cantidad" => 1,
    //             "articulo" => "EMPANADAS DE SFIJAS",
    //         ), 
    //         array(
    //             "cantidad" => 1,
    //             "articulo" => "GASEOSA 500 LINEA PEPSI",
    //         ),
    //     );

    //     $pusher->trigger('pedidos-pendientes', 'App\Events\EventoPedidos', $data);


    //     return "evento generado";
    // });


    // compras
    // Route::get('compras', 'ComprasController@index')->name("compras")->middleware(['permission:compra-index']);
    // Route::get('compras/edit/{id}', 'ComprasController@edit')->middleware(['permission:compra-edit']);
    // Route::get('compras/{id}/show', 'ComprasController@show')->middleware(['permission:compra-show']);
    // Route::put('compras/edit/{id}/update', 'ComprasController@update')->middleware(['permission:compra-update']);
    // Route::post('compras/edit/{id}/comprobante', 'ComprasController@comprobante')->middleware(['permission:compra-comprobante']);
    // Route::get('compras/filtro', 'ComprasController@filtro')->middleware(['permission:compra-filtro']);
    // Route::post('compras/compras', 'ComprasController@store')->middleware(['permission:compra-store']);
    // Route::get('compras/nuevo', 'ComprasController@nuevo')->middleware(['permission:compra-nuevo']);
    // Route::delete('compras/{id}/destroy', 'ComprasController@destroy')->middleware(['permission:compra-destroy']);
 


    // ROLES 
    // Route::get('roles','RolesController@index')->name('role.index') ->middleware(['permission:ver.roles']);
    // Route::get('roles/nuevo','RolesController@create')->name('role.index') ->middleware(['permission:agregar.roles']);
    // Route::get('roles/edit/{id}','RolesController@edit')->name('role.edit') ->middleware(['permission:editar.roles']);
    // Route::post('roles','RolesController@store')->name('role.store') ->middleware(['permission:agregar.roles']);
    // Route::put('roles','RolesController@update')->name('role.update') ->middleware(['permission:editar.roles']); 
    // Route::delete('roles','RolesController@destroy')->name('role.destroy') ->middleware(['permission:eliminar.roles']);



    // articulo
    Route::get('articulos', 'ArticuloController@index')->name("articulos.index")->middleware(['permission:articulo-index']);
    Route::get('articulos/filtro', 'ArticuloController@filtro')->middleware(['permission:articulo-filtro']);
    Route::delete('articulos/{id}/delete', 'ArticuloController@destroy')->middleware(['permission:articulo-destroy']);
    Route::get('articulos/{id}/editar', 'ArticuloController@editar')->name("articulo.edit")->middleware(['permission:articulo-editar']);
    Route::put('articulos/{id}/editar', 'ArticuloController@edit')->middleware(['permission:articulo-editar']);
    Route::put('articulos/stock', 'ArticuloController@stock')->middleware(['permission:articulo-editar-stock']);
    Route::post('articulos', 'ArticuloController@store')->middleware(['permission:articulo-store']);
    // Route::post('articulos/{articulo}/images', 'ArticuloController@images');
    // Route::post('articulos/{articulo}/images/{image}', 'ArticuloController@imagesDelete');
    // Route::post('articulos/actualizarprecios', 'ArticuloActualizarPreciosController@store');
    // Route::get('articulos/actualizarprecios/{id}', 'ArticuloActualizarPreciosController@show');


    // categorias
    Route::get('categorias', 'CategoriaController@index')->middleware(['permission:categoria-index']);
    Route::post('categorias', 'CategoriaController@store')->middleware(['permission:categoria-store']);
    Route::delete('categorias/{id}/delete', 'CategoriaController@destroy')->middleware(['permission:categoria-destroy']);
    Route::put('categorias', 'CategoriaController@edit')->middleware(['permission:categoria-edit']);
    // Route::get('categorias/{subcategoria}/subcategorias', 'CategoriaController@subcategorias');


    // marca
    // Route::get('marcas', 'MarcaController@index')->middleware(['permission:marca-index']);
    // Route::post('marcas', 'MarcaController@store')->middleware(['permission:marca-store']);
    // Route::delete('marcas/{id}/delete', 'MarcaController@destroy')->middleware(['permission:marca-destroy']);
    // Route::put('marcas', 'MarcaController@edit')->middleware(['permission:marca-edit']);


    // empresa
    // Route::get('empresa', 'EmpresaController@index')->middleware(['permission:empresa-index']);
    // Route::put('empresa', 'EmpresaController@update')->middleware(['permission:empresa-update']);
    // Route::post('empresa/logoventas', 'EmpresaController@logoventas')->middleware(['permission:empresa-logoventas']);
    // Route::post('empresa/logoprofile', 'EmpresaController@logoprofile')->middleware(['permission:empresa-logoprofile']);

    // notificaciones
    Route::get('notificaciones', 'NotificacionesController@index')->middleware(['permission:notificacion-index']);
    Route::delete('notificaciones', 'NotificacionesController@destroy')->middleware(['permission:notificacion-destroy']);



    Route::get('estadisticas', 'EstadisticasController@index')->name("estadisticas.index")->middleware(['permission:ver-estadisticas']);
    
    Route::get('estadisticas/articulos_vendidos_por_dia', 'EstadisticasController@articulos')->name("estadisticas.articulos")->middleware(['permission:ver-estadisticas-articulos']);

    // reportes
    // Route::get('reportes', 'ReportesController@index')->name("reportes")->middleware(['permission:reportes-index']);
    // Route::get('reportes-ventas', 'ReportesController@ventas')->name("reportes-ventas")->middleware(['permission:reportes-index']);
    // Route::get('reportes-ventas/filtro', 'ReportesController@filtro')->middleware(['permission:reportes-index']);
});
