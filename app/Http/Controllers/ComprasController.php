<?php

namespace App\Http\Controllers;

use App\User;
use App\Precio;
use App\Cliente;
use App\Compras;
use App\Articulo;
use App\Reportes;
use App\TipoPago;
use App\Proveedor;
use Carbon\Carbon;
use App\ProveedorCC;
use App\CompraDetalle;
use App\CompraDetallePago;
use App\ProveedorCCDetalle;
use Illuminate\Http\Request;

class ComprasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //'id','user_id','proveedor_id','monto','fecha','eliminado','creator_id','eliminado','created_at','updated_at'

        $cantidad = Compras::select(\DB::raw("count(*) as cantidad"))->where("compras.fecha", date("Y-m-d"))->where("eliminado", false)->where("eliminado", false)->first();
        $monto = Compras::select(\DB::raw("sum(monto) as cantidad"))->where("compras.fecha", date("Y-m-d"))->where("eliminado", false)->where("eliminado", false)->first();

        // $proveedores =  Proveedor::select("id", "nombre")->where("eliminado", false)->pluck("nombre", "id");

        $compras = Compras::select('compras.id', 'compras.fecha', 'compras.hora',  'compras.monto',  'proveedor.nombre', 'compras.pago_completo')
            ->leftjoin("proveedor", "proveedor.id", '=', 'compras.proveedor_id')
            ->where("compras.fecha", date("Y-m-d"))
            ->where('compras.eliminado', false)
            ->orderby("compras.id", 'desc')
            ->paginate(15);

        return view("compras.index", compact("compras", "cantidad", "monto"));
    }



    public function nuevo()
    {
        $proveedores = Proveedor::select("id", "nombre")->where("eliminado", false)->pluck("nombre", "id");
        $tipo_pagos =  TipoPago::select("tipo_pago", "id")->where("eliminado", false)->pluck("tipo_pago", "id");

        $articulos = Articulo::select("id", 'articulo', 'stock', "precio_compra", 'precio_venta')
            // ->where("habilitado",true)
            ->where("eliminado", false)->get();

        return view("compras.nuevo", compact("proveedores", "articulos", "tipo_pagos"));
    }



    public function filtro(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date',
            'proveedor' => 'nullable|numeric',
            'empleado' => 'nullable|numeric',
            'estadopago' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $fecha_desde = request()->fecha_desde ? request()->fecha_desde : null;
        $fecha_hasta = request()->fecha_hasta ? request()->fecha_hasta : null;
        $proveedor = (request()->proveedor != 0) ? request()->proveedor : null;
        $empleado = request()->empleado ? request()->empleado : null;
        $estadopago = request()->estadopago;

        if (request()->estadopago == 0) $estadopago = null;
        if (request()->estadopago == 1) $estadopago = true; // pago completo
        if (request()->estadopago == 2) $estadopago = false; // pago incompleto

        $compras = Compras::select('compras.id', 'compras.fecha', 'compras.hora',  'compras.monto',  'proveedor.nombre', 'compras.pago_completo')
            ->leftjoin("proveedor", "proveedor.id", '=', 'compras.proveedor_id')
            ->where('compras.eliminado', false);

        if ($fecha_desde !== null && $fecha_hasta !== null) {
            $compras = $compras->whereBetween("compras.fecha", [$fecha_desde, $fecha_hasta]);
        }
        if ($fecha_desde !== null && $fecha_hasta == null) {
            $compras = $compras->whereBetween("compras.fecha", [$fecha_desde, $fecha_desde]);
        }
        if ($fecha_desde == null && $fecha_hasta !== null) {
            $compras = $compras->whereBetween("compras.fecha", [$fecha_hasta, $fecha_hasta]);
        }
        if ($proveedor !== null) {
            $compras = $compras->where("compras.proveedor_id", $proveedor);
        }
        if ($estadopago !== null) {
            $compras = $compras->where("compras.pago_completo", $estadopago);
        }
        // if($empleado){
        //     // verificar rol empleado del user_id 
        //     $compras = $compras->where("compras.user_id");
        // }
        $compras = $compras->orderBy("compras.fecha", 'desc');
        $compras = $compras->paginate(15);

        return response()->json(view("compras.index_data", compact("compras"))->render());
    }



    public function edit($id)
    {




        // 'id','user_id','proveedor_id','monto','fecha','descuento_porcentaje','descuento_importe','pago_completo',"comentario",'eliminado','creator_id', 'created_at','updated_at'
        $compra = Compras::select('id', 'fecha', 'monto', \DB::raw("(monto-descuento_importe) as subtotal"), 'proveedor_id', 'descuento_porcentaje', "descuento_importe", "pago_completo", "comentario")
            ->where('eliminado', false)
            ->where("id", $id)
            ->first();
        if (!$compra) {
            return redirect()->route("compras");
        }

        $proveedores = Proveedor::select("id", "nombre")->where("eliminado", false)->pluck("nombre", "id");
        $articulos = Articulo::select("id", 'articulo', 'stock', "precio_compra", 'precio_venta')
            ->where("habilitado", true)
            ->where("eliminado", false)->get();


        $tipo_pagos =  TipoPago::select("tipo_pago", "id")->where("eliminado", false)->pluck("tipo_pago", "id");

        $detalles = CompraDetalle::select("cantidad", "subtotal", "articulo", "precio_compra", "precio_venta", "articulo_id", "id")->where("compra_id", $id)->where("eliminado", false)->get();
        // $pagos = CompraDetallePago::select("efectivo", "debito", "credito", "cheque", "cc", "otro", "vuelto")->where("compra_id", $id)->get();

        $pagos = CompraDetallePago::select("compras_detalle_pago.monto","tipopago.tipo_pago")
            ->leftjoin("tipopago","tipopago.id","=","compras_detalle_pago.tipopago_id")
            // ->where("tipopago.eliminado",false)
            ->where("compras_detalle_pago.eliminado",false)
            ->where("compra_id", $id)
            ->get();



        return view("compras.edit", compact("compra", "detalles", "pagos", "proveedores", "articulos","tipo_pagos"));
    }






    public function show(Request $request, $id)
    {



        // 'id','user_id','proveedor_id','monto','fecha','descuento_porcentaje','descuento_importe','pago_completo',"comentario",'eliminado','creator_id', 'created_at','updated_at'
        $compra = Compras::select('compras.fecha', 'compras.monto', \DB::raw("(compras.monto-compras.descuento_importe) as subtotal"), 'proveedor.nombre as proveedor_nombre', 'users.nombre as users_nombre', 'compras.descuento_porcentaje', "compras.descuento_importe", "compras.pago_completo", "compras.comentario")
            ->leftjoin("proveedor", "proveedor.id", "=", "compras.id")
            ->leftjoin("users", "users.id", "=", "compras.user_id")
            ->where('compras.eliminado', false)
            ->where("compras.id", $id)
            ->first();

        if (!$compra && $request->ajax()) {
            return response()->json(["status" => "error", "message" => "Compra no existe!"]);
        }
        if (!$compra)  return redirect()->route("compras");

        $detalles = CompraDetalle::select("cantidad", "subtotal", "articulo", "precio_compra", "precio_venta", "articulo_id", "id")->where("compra_id", $id)->where("eliminado", false)->get();
        // $pagos = CompraDetallePago::select("efectivo", "debito", "credito", "cheque", "cc", "otro", "vuelto")->where("compra_id", $id)->get();

        $pagos = CompraDetallePago::select("compras_detalle_pago.monto","tipopago.tipo_pago")
            ->leftjoin("tipopago","tipopago.id","=","compras_detalle_pago.tipopago_id")
            // ->where("tipopago.eliminado",false)
            ->where("compras_detalle_pago.eliminado",false)
            ->where("compra_id", $id)
            ->get();
            
        if ($request->ajax()) {
            return response()->json(view("compras.detalles_data", compact("compra", "detalles", "pagos"))->render());
        }

        return view("compras.detalles", compact("compra", "detalles", "pagos"));
    }







    public function store(Request $request)
    {
        //'id','fecha','punto_venta','codigo','cliente_id','user_id','monto','descuento_porcentaje',
        // 'descuento_importe','eliminado','creator_id','created_at','updated_at'

        $user_id = auth()->user()->id;

        $validator = \Validator::make($request->all(), [
            'proveedor' => 'nullable|numeric',
            'fecha' => 'nullable|date',
            'articulos' => 'required|array',
            'descuentos' => 'nullable|array',
            // 'pagos' => 'nullable|array',
            'pagos_id' => 'nullable|numeric',
            'pagos_monto' => 'nullable|numeric',
            'comentario' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $proveedor =  request()->proveedor  ? $request->proveedor : 1;
        $pagos_id =  request()->pagos_id ;
        $pagos_monto = (request()->pagos_monto !==-1)? request()->pagos_monto : null;
        $fecha =  request()->fecha  ? $request->fecha : date("Y-m-d");
        $articulos = request()->articulos ? request()->articulos : null;
        $descuentos = request()->descuentos ? request()->descuentos : null;
        $pagos = request()->pagos ? request()->pagos : null;
        $comentario = request()->comentario ? request()->comentario : null;

        if ($articulos) {
            $monto = null;
        }
        $data = array();
        $data["user_id"] = $user_id;
        $data["fecha"] =  $fecha;
        // $data["hora"] =  date('H:m');
        $data["proveedor_id"] = $proveedor;

        if ($proveedor > 1) {
            $proveedor_id = Proveedor::select("nombre")->where("id", $proveedor)->where("eliminado", false)->first();
            if (!$proveedor_id) {
                return response()->json(["status" => "error", "message" => "Proveedor no existe!"]);
            }
            $data["proveedor_id"] = $proveedor;
        }
        if ($descuentos) {
            foreach ($descuentos as $item) {
                $data["descuento_porcentaje"] = (isset($item["porcentaje"]) && $item["porcentaje"] != null) ? $item["porcentaje"] : 0;
                $data["descuento_importe"] = (isset($item["monto"]) && $item["monto"] != null) ? $item["monto"] : 0;
            }
        }
        if ($comentario) {
            $data["comentario"] = $comentario;
        }
         
        // 'id','fecha','punto_venta','codigo','cliente_id','user_id','monto','descuento_porcentaje',
        // 'descuento_importe','cae','comentario','eliminado','creator_id',"caja_id",'created_at','updated_at'
        $compra = Compras::create($data);
        $compra_id = $compra->id;
        // return response()->json([$venta]);



        $total = 0;
        if ($articulos) {
            // articulo_id: articulo_id,
            // articulo_cantidad: articulo_cantidad,
            // articulo_descuento: articulo_descuento
            foreach ($articulos as $item) {
                $articulo_id  =  (isset($item["articulo_id"]) && $item["articulo_id"] !== null) ? $item["articulo_id"] : null;
                $cantidad = (isset($item["articulo_cantidad"]) && $item["articulo_cantidad"] !== null) ?  $item["articulo_cantidad"] : 1;
                $precio_compra  =  (isset($item["precio_compra"]) && $item["precio_compra"] !== null) ? $item["precio_compra"] : null;
                $precio_venta  =  (isset($item["precio_venta"]) && $item["precio_venta"] !== null) ? $item["precio_venta"] : null;

                if ($articulo_id == null) continue;
                // 'id', 'articulo', 'codigo', 'codigo_barras', 'stock', 'stock_minimo',  'precio_compra','precio_venta','precio_neto_venta',
                // 'marca_id','categoria_id', 'subcategoria_id', 'tasa_iva_id', 'precio_id', 'creator_id',
                // 'habilitado', 'eliminado', 'created_at', 'updated_at'
                $articulo =  Articulo::select("articulo", "precio_compra", "precio_venta", "stock")
                    ->where("id", $item['articulo_id'])
                    ->where("eliminado", false)
                    ->first();

                if (!$articulo) continue; // si no existe producto continua el blucle
                $subtotal =  $cantidad * $precio_compra;

                // id','venta_id','articulo_id','articulo','cantidad','subtotal',  'creator_id','eliminado','created_at','updated_at'
                $venta_detalle = CompraDetalle::create([
                    "cantidad" => $cantidad,
                    "precio_venta" => $precio_venta,
                    "precio_compra" => $precio_compra,
                    "subtotal" => $subtotal,
                    // "descuento" => $descuento,
                    "articulo" => $articulo['articulo'],
                    "articulo_id" => $articulo_id,
                    "compra_id" => $compra_id,
                    "user_id" => $user_id,
                ]);
                // incrementar  stock 
                if ($venta_detalle) {
                    $articulo =  Articulo::where("id", $articulo_id)
                        ->where("eliminado", false)
                        ->increment("stock", $cantidad);
                }
                // incrementar  stock 

                // actualizar precios
                // 'id','precio_neto_venta','precio_compra','precio_venta','precio_descuento_porc','precio_descuento_impor','estado',
                // 'user_id','creator_id','eliminado','created_at','updated_at'
                if (($precio_compra !== $articulo["precio_compra"]) || ($precio_venta !== $articulo["precio_venta"])) {
                    $precioss = Precio::create(["precio_compra" => $precio_compra, "precio_venta" => $precio_venta, "user_id" => $user_id]);
                    $articulo =  Articulo::where("id", $articulo_id)
                        ->where("eliminado", false)
                        ->update(["precio_compra" => $precio_compra, "precio_venta" => $precio_venta, "precio_id" => $precioss->id]);
                }
                // actualizar precios

                // $errors[] = array(["message" => "Articulo " . $item['articulo_id'] . " stock insuficiente!"]);
                $total =  $total + $subtotal;
            } // end foreach
            // descuento general
            if (isset($descuentos["porcentaje"]) && !empty($descuentos["porcentaje"])) {
                $total = $total - ($total * ($descuentos["porcentaje"] / 100));
            }
            // if ($descuentos["descuento_importe"]) {
            //     $total = $total - $descuentos["descuento_importe"];
            // }
            Compras::where("id", $compra_id)
                ->where("eliminado", false)
                ->update(["monto" => $total]);

            $mes_fecha = date("m", strtotime($fecha));
            $anio_fecha = date("Y", strtotime($fecha));
            Reportes::firstOrCreate(["mes" => $mes_fecha, "anio" => $anio_fecha, "eliminado" => false]);
            Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("monto_compras", $total);
            Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("cantidad_compras", 1);
        }

        $suma = 0;
        // if ($pagos) {
        //     foreach ($pagos as $item) {
        //         $efectivo = (isset($item["efectivo"]) && !empty($item["efectivo"])) ? $item["efectivo"] : null;
        //         $debito = (isset($item["debito"]) && !empty($item["debito"])) ? $item["debito"] : null;
        //         $credito = (isset($item["credito"]) && !empty($item["credito"])) ? $item["credito"] : null;
        //         $cheque = (isset($item["cheque"]) && !empty($item["cheque"])) ? $item["cheque"] : null;
        //         $cc = (isset($item["cc"]) && !empty($item["cc"])) ? $item["cc"] : null;
        //         $otro = (isset($item["otro"]) && !empty($item["otro"])) ? $item["otro"] : null;

        //         if ($efectivo == null && $debito == null && $credito == null && $cheque == null && $cc == null && $otro == null) continue;

        //         if ($cc && $proveedor_id > 0) {
        //             $ccorriente = ProveedorCC::select("proveedor_id")->where("proveedor_id", $proveedor_id)->first();
        //             if (!$ccorriente) {
        //                 ProveedorCC::create(["proveedor_id" => $proveedor_id]);
        //             }
        //             ProveedorCC::where("proveedor_id", $proveedor_id)->increment("monto", $cc);
        //             ProveedorCCDetalle::create(["proveedor_id" => $proveedor_id, "compra_id" => $compra_id, "fecha" => $fecha, "monto" => $cc]);
        //         }
        //         // pago a cuenta corriente es una venta completa
        //         if ($total == $cc) {
        //             Compras::where("id", $compra_id)
        //                 ->where("eliminado", false)
        //                 ->update(["pago_completo" => true]);
        //         }

        //         $suma += $efectivo + $debito + $credito + $cheque + $cc + $otro;

        //         // $vuelto = $suma  - $total;
        //         // $vuelto = $vuelto == 0 ? null : $vuelto;
        //         $venta_pago = CompraDetallePago::create([
        //             "efectivo" => $efectivo,
        //             "debito" => $debito,
        //             "credito" => $credito,
        //             "cheque" => $cheque,
        //             "cc" => $cc,
        //             "otro" => $otro,
        //             // "vuelto" => $vuelto,
        //             "compra_id" => $compra_id,
        //             "user_id" => $user_id,
        //         ]);
        //     }
        // }
        if($pagos_id >0 ){
            // si es cc verifico cc del cliente, si no existe cc la creo, 5 cuenta corriente
            if ($pagos_id == 5 && $proveedor_id > 0) { 
                $ccorriente = ProveedorCC::select("proveedor_id")->where("proveedor_id", $proveedor_id)->first();
                if (!$ccorriente) {
                    ProveedorCC::create(["proveedor_id" => $proveedor_id]);
                }
                ProveedorCC::where("proveedor_id", $proveedor_id)->increment("monto", $pagos_monto);
                ProveedorCCDetalle::create(["proveedor_id" => $proveedor_id, "compra_id" => $compra_id, "fecha" => $fecha, "monto" => $pagos_monto]);
            }
            $venta_pago = CompraDetallePago::create([
                "tipopago_id" => $pagos_id,
                "monto" => $pagos_monto,
                "compra_id" => $compra_id,
                // "creator_id" => $user_id,
            ]);
            $suma += $pagos_monto;
        }
        $vdp = CompraDetallePago::select(\DB::raw("sum(monto) as monto"))->where("compra_id", $compra_id)->first();
        $suma = $vdp->monto;


        if ($suma >= $total) {
            Compras::where("id", $compra_id)
                ->where("eliminado", false)
                ->update(["pago_completo" => true]);
        }


        if ($compra) {
            return response()->json(["status" => "success", "message" => "Guardado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error, no se pudo guardar!"]);
    }




    public function update(Request $request, $id)
    {
        //'id','fecha','punto_venta','codigo','cliente_id','user_id','monto','descuento_porcentaje',
        // 'descuento_importe','eliminado','creator_id','created_at','updated_at'

        $user_id = auth()->user()->id;
        $compra = Compras::select("id")->where("id", $id)->where("eliminado", false)->first();
        if (!$compra) {
            return response()->json(["status" => "error", "message" => "Compra no existe!"]);
        }

        $validator = \Validator::make($request->all(), [
            'proveedor' => 'nullable|numeric',
            'fecha' => 'nullable|date',
            'articulos' => 'nullable|array',
            'eliminados' => 'nullable|array',
            'descuentos' => 'nullable|array',
            'pagos_id' => 'nullable|numeric',
            'pagos_monto' => 'nullable|numeric',
            // 'pagos' => 'nullable|array',
            'comentario' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $proveedor =  request()->proveedor  ? $request->proveedor : 1;
        $fecha =  request()->fecha  ? $request->fecha : date("Y-m-d");
        $pagos_id =  request()->pagos_id ;
        $pagos_monto = (request()->pagos_monto !==-1)? request()->pagos_monto : null;
        $articulos = request()->articulos ? request()->articulos : null;
        $eliminados = request()->eliminados ? request()->eliminados : null;
        $descuentos = request()->descuentos ? request()->descuentos : null;
        $pagos = request()->pagos ? request()->pagos : null;
        $comentario = request()->comentario ? request()->comentario : null;

        if ($articulos) {
            $monto = null;
        }
        $data = array();
        $data["user_id"] = $user_id;
        $data["fecha"] =  $fecha;
        // $data["hora"] =  date('H:m');
        $data["proveedor_id"] = $proveedor;

        if ($proveedor > 1) {
            $proveedor_id = Proveedor::select("nombre")->where("id", $proveedor)->where("eliminado", false)->first();
            if (!$proveedor_id) {
                return response()->json(["status" => "error", "message" => "Proveedor no existe!"]);
            }
            $data["proveedor_id"] = $proveedor;
        }
        if ($descuentos) {
            foreach ($descuentos as $item) {
                $data["descuento_porcentaje"] = (isset($item["porcentaje"]) && $item["porcentaje"] != null) ? $item["porcentaje"] : 0;
                $data["descuento_importe"] = (isset($item["monto"]) && $item["monto"] != null) ? $item["monto"] : 0;
            }
        }
        if ($comentario) {
            $data["comentario"] = $comentario;
        }

        // 'id','fecha','punto_venta','codigo','cliente_id','user_id','monto','descuento_porcentaje',
        // 'descuento_importe','cae','comentario','eliminado','creator_id',"caja_id",'created_at','updated_at'
        $compra =  Compras::select("fecha", "monto")->where("id", $id)->where("eliminado", false)->first();

        $mes_fecha = date("m", strtotime($compra->fecha));
        $anio_fecha = date("Y", strtotime($compra->fecha));
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_compras", $compra->monto);

        $compra =  Compras::where("id", $id)->where("eliminado", false)->update($data);
        $compra_id = $id;



        // return response()->json([$venta]);



        if ($eliminados) {
            foreach ($eliminados as $item) {
                $articulo_id  =  (isset($item["articulo_id"]) && $item["articulo_id"] !== null) ? $item["articulo_id"] : null;
                $detalle_id  =  (isset($item["id"]) && $item["id"] !== null) ? $item["id"] : null;

                if ($articulo_id == null) continue;
                $compra_detalle = CompraDetalle::select("subtotal", "cantidad")->where("compra_id", $compra_id)->where("id", $detalle_id)->where("eliminado", false)->first();
                if (!empty($compra_detalle)) {
                    // restaurar stock del producto
                    if ($compra_detalle->cantidad > 0) {
                        Articulo::where("id", $articulo_id)->where("eliminado", false)->decrement("stock", $compra_detalle->cantidad);
                    }
                    // eliminar detalle compra
                    CompraDetalle::where("compra_id", $compra_id)->where("id", $detalle_id)->where("eliminado", false)->update(["eliminado" => true]);
                    // actualizar monto compra
                    Compras::where("id", $compra_id)->where("eliminado", false)->decrement("monto", $compra_detalle->subtotal);
                }
            }
        }


        $total = 0;
        if ($articulos) {
            // articulo_id: articulo_id,
            // articulo_cantidad: articulo_cantidad,
            // articulo_descuento: articulo_descuento
            foreach ($articulos as $item) {
                $articulo_id  =  (isset($item["articulo_id"]) && $item["articulo_id"] !== null) ? $item["articulo_id"] : null;
                $cantidad = (isset($item["articulo_cantidad"]) && $item["articulo_cantidad"] !== null) ?  $item["articulo_cantidad"] : 1;
                $precio_compra  =  (isset($item["precio_compra"]) && $item["precio_compra"] !== null) ? $item["precio_compra"] : null;
                $precio_venta  =  (isset($item["precio_venta"]) && $item["precio_venta"] !== null) ? $item["precio_venta"] : null;

                if ($articulo_id == null) continue;
                // 'id', 'articulo', 'codigo', 'codigo_barras', 'stock', 'stock_minimo',  'precio_compra','precio_venta','precio_neto_venta',
                // 'marca_id','categoria_id', 'subcategoria_id', 'tasa_iva_id', 'precio_id', 'creator_id',
                // 'habilitado', 'eliminado', 'created_at', 'updated_at'
                $articulo =  Articulo::select("articulo", "precio_compra", "precio_venta", "stock")
                    ->where("id", $item['articulo_id'])
                    ->where("eliminado", false)
                    ->first();

                if (!$articulo) continue; // si no existe producto continua el blucle
                $subtotal =  $cantidad * $precio_compra;

                // id','venta_id','articulo_id','articulo','cantidad','subtotal',  'creator_id','eliminado','created_at','updated_at'
                $venta_detalle = CompraDetalle::create([
                    "cantidad" => $cantidad,
                    "precio_venta" => $precio_venta,
                    "precio_compra" => $precio_compra,
                    "subtotal" => $subtotal,
                    // "descuento" => $descuento,
                    "articulo" => $articulo['articulo'],
                    "articulo_id" => $articulo_id,
                    "compra_id" => $compra_id,
                    "user_id" => $user_id,
                ]);
                // incrementar  stock 
                if ($venta_detalle) {
                    $articulo =  Articulo::where("id", $articulo_id)
                        ->where("eliminado", false)
                        ->increment("stock", $cantidad);
                }
                // incrementar  stock 

                // actualizar precios
                // 'id','precio_neto_venta','precio_compra','precio_venta','precio_descuento_porc','precio_descuento_impor','estado',
                // 'user_id','creator_id','eliminado','created_at','updated_at'
                if (($precio_compra !== $articulo["precio_compra"]) || ($precio_venta !== $articulo["precio_venta"])) {
                    $precioss = Precio::create(["precio_compra" => $precio_compra, "precio_venta" => $precio_venta, "user_id" => $user_id]);
                    $articulo =  Articulo::where("id", $articulo_id)
                        ->where("eliminado", false)
                        ->update(["precio_compra" => $precio_compra, "precio_venta" => $precio_venta, "precio_id" => $precioss->id]);
                }
                // actualizar precios

                // $errors[] = array(["message" => "Articulo " . $item['articulo_id'] . " stock insuficiente!"]);
                $total =  $total + $subtotal;
            } // end foreach
            // descuento general
            if (isset($descuentos["porcentaje"]) && !empty($descuentos["porcentaje"])) {
                $total = $total - ($total * ($descuentos["porcentaje"] / 100));
            }
            // if ($descuentos["descuento_importe"]) {
            //     $total = $total - $descuentos["descuento_importe"];
            // }
            Compras::where("id", $compra_id)
                ->where("eliminado", false)
                ->increment("monto", $total);

            $mes_fecha = date("m", strtotime($fecha));
            $anio_fecha = date("Y", strtotime($fecha));
            Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("monto_compras", $total);
        }


        $suma = 0;
        // if ($pagos) {
        //     foreach ($pagos as $item) {
        //         $efectivo = (isset($item["efectivo"]) && !empty($item["efectivo"])) ? $item["efectivo"] : null;
        //         $debito = (isset($item["debito"]) && !empty($item["debito"])) ? $item["debito"] : null;
        //         $credito = (isset($item["credito"]) && !empty($item["credito"])) ? $item["credito"] : null;
        //         $cheque = (isset($item["cheque"]) && !empty($item["cheque"])) ? $item["cheque"] : null;
        //         $cc = (isset($item["cc"]) && !empty($item["cc"])) ? $item["cc"] : null;
        //         $otro = (isset($item["otro"]) && !empty($item["otro"])) ? $item["otro"] : null;

        //         if ($efectivo == null && $debito == null && $credito == null && $cheque == null && $cc == null && $otro == null) continue;

        //         if ($cc && $proveedor_id > 0) {
        //             $ccorriente = ProveedorCC::select("proveedor_id")->where("proveedor_id", $proveedor_id)->first();
        //             if (!$ccorriente) {
        //                 ProveedorCC::create(["proveedor_id" => $proveedor_id]);
        //             }
        //             ProveedorCC::where("proveedor_id", $proveedor_id)->increment("monto", $cc);
        //             ProveedorCCDetalle::create(["proveedor_id" => $proveedor_id, "compra_id" => $compra_id, "fecha" => $fecha, "monto" => $cc]);
        //         }
        //         // pago a cuenta corriente es una venta completa
        //         if ($total == $cc) {
        //             Compras::where("id", $compra_id)
        //                 ->where("eliminado", false)
        //                 ->update(["pago_completo" => true]);
        //         }

        //         $suma += $efectivo + $debito + $credito + $cheque + $cc + $otro;
        //         // $vuelto = $suma  - $total;
        //         // $vuelto = $vuelto == 0 ? null : $vuelto;
        //         $venta_pago = CompraDetallePago::create([
        //             "efectivo" => $efectivo,
        //             "debito" => $debito,
        //             "credito" => $credito,
        //             "cheque" => $cheque,
        //             "cc" => $cc,
        //             "otro" => $otro,
        //             // "vuelto" => $vuelto,
        //             "compra_id" => $compra_id,
        //             "user_id" => $user_id,
        //         ]);
        //     }
        // }

        if($pagos_id >0 ){
            // si es cc verifico cc del cliente, si no existe cc la creo, 5 cuenta corriente
            if ($pagos_id == 5 && $proveedor_id > 0) { 
                $ccorriente = ProveedorCC::select("proveedor_id")->where("proveedor_id", $proveedor_id)->first();
                if (!$ccorriente) {
                    ProveedorCC::create(["proveedor_id" => $proveedor_id]);
                }
                ProveedorCC::where("proveedor_id", $proveedor_id)->increment("monto", $pagos_monto);
                ProveedorCCDetalle::create(["proveedor_id" => $proveedor_id, "compra_id" => $compra_id, "fecha" => $fecha, "monto" => $pagos_monto]);
            }
            $venta_pago = CompraDetallePago::create([
                "tipopago_id" => $pagos_id,
                "monto" => $pagos_monto,
                "compra_id" => $compra_id,
                // "creator_id" => $user_id,
            ]);
            $suma += $pagos_monto;
        }

        $vdp = CompraDetallePago::select(\DB::raw("sum(monto) as monto"))->where("compra_id", $compra_id)->first();
        $suma = $vdp->monto;

        if ($suma >= $total) {
            Compras::where("id", $compra_id)->where("eliminado", false)->update(["pago_completo" => true]);
        }


        if ($compra) {
            return response()->json(["status" => "success", "message" => "Editado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error al editar!"]);
    }







    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ComprasController  $comprasController
     * @return \Illuminate\Http\Response
     */
    public function destroy($compra_id)
    {
        //

        $creator_id = auth()->user()->creator_id;
        $compra = Compras::select("fecha", "monto")->where("id", $compra_id)->where("eliminado", false)->first();

        if (!$compra) return response()->json(["status" => "success", "message" => "Error, no se pudo eliminar"]);

        Compras::where("id", $compra_id)->where("eliminado", false)->update([
            "eliminado" => true
        ]);


        $mes_fecha = date("m", strtotime($compra->fecha));
        $anio_fecha = date("Y", strtotime($compra->fecha));
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_compras", $compra->monto);
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("cantidad_compras", 1);



        if ($compra) {
            // restaurar stock de los productos 
            $compra_detalles = CompraDetalle::select("articulo_id", "cantidad")->where("compra_id", $compra_id)->where("eliminado", false)->get();
            if ($compra_detalles) {
                foreach ($compra_detalles as $key) {
                    Articulo::where("id", $key["articulo_id"])->where("eliminado", false)->increment("stock", $key["cantidad"]);
                }
                CompraDetalle::where("compra_id", $compra_id)->where("eliminado", false)->update(["eliminado" => true]);
            }
            return response()->json(["status" => "success", "message" => "Eliminado"]);
        }

        return response()->json(["status" => "success", "message" => "Error, no se pudo eliminar"]);
    }
}
