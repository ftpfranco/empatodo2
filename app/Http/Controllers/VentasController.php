<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use App\Cajas;
use App\Gasto;
use App\Turno;
use App\Ventas;
use App\Cliente;
use App\Empresa;
use App\Articulo;
use App\Reportes;
use App\TipoPago;
use App\ClienteCC;
use Pusher\Pusher;
use App\Categorias;
// use Barryvdh\DomPDF\Facade as PDF;
use App\CajasDetalle;
use App\Notificacion;
use App\ArticuloPorDia;
use App\ClienteCCDetalle;
use App\VentaDetallePago;
use App\VentasEstadoEnvio;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Events\EventoPedidos;
// use Mews\Purifier\Facades\Purifier;
use App\VentaDetalleArticulo;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    { 
        // $sum = Ventas::select(\DB::raw("sum(total_recibido) as monto, count(*) as cantidad ,to_char(fecha,'YYYY-MM') "))->where("eliminado",false)->where("tipoenvio_id",3)->where("pago_completo",true)->groupby(\DB::raw("to_char(fecha,'YYYY-MM')"))->get()->toarray();
        // echo "<pre>";
        // print_r($sum);
        // echo "<pre>";
        // die();
        // crear categorias
        // venta 367 tiene 640 deberia ser 690 
        // $deta = VentaDetalleArticulo::select(\DB::raw("sum(subtotal) as total"),"venta_id")->where("eliminado",false) ->groupby("venta_id")->get();
        // foreach ($deta as $key => $value) {
        //     Ventas::where("eliminado",false)->where("id",$value["venta_id"])->update(["monto"=>$value["total"]]);
        // }
        // dd($deta);
        // correr esto para reajustar pagos recibidos 2022/02/16
        // 'id','venta_id',"tipopago_id",'monto',"comentario",'creator_id','eliminado','created_at','updated_at'
        // $pagos = VentaDetallePago::select(   "tipopago_id" , "venta_id"   ) ->where("eliminado",false) ->where("monto",">",0)      ->get();
        // if($pagos){
        //     foreach ($pagos as $key => $value) {
        //         Ventas::where("id",$value["venta_id"])->where("eliminado",false)->update(["tipopago_id"=>$value["tipopago_id"]]);
        //     }
        // }
        // dd("listo");
        // dd($pagos);
        // end correr esto para reajustar pagos recibidos


        $debito_id = 2; // tipo debito
        $credito_id = 3; // tipo credito
        $user_id = auth()->user()->id;

        $t1_hora_desde = "07:30";
        $t1_hora_hasta = "16:00";

        $t2_hora_desde = "16:01";
        $t2_hora_hasta = "23:59";
        
        if(auth()->user()->es_empleado == true){
            $turno = Turno::select( \DB::raw("to_char(time1_start,'HH24:MI') as time1_start"),\DB::raw("to_char(time1_end,'HH24:MI') as time1_end"), \DB::raw("to_char(time2_start,'HH24:MI') as time2_start"), \DB::raw("to_char(time2_end,'HH24:MI') as time2_end"))->where("user_id",$user_id)->where("eliminado",false)->first();
            $t1_hora_desde = $turno["time1_start"];
            $t1_hora_hasta = $turno["time1_end"];
            
            $t2_hora_desde = $turno["time2_start"];
            $t2_hora_hasta = $turno["time2_end"];
        }

        $campana = false;

        $cantidad_completas = Ventas::select(\DB::raw("count(*) as cantidad"))->where("ventas.fecha", date("Y-m-d"))->where("eliminado", false)->where("pago_completo", true);
        $monto_debito = VentaDetallePago::select(\DB::raw("sum(ventas_detalle_pago.monto) as cantidad"))
            ->leftjoin("ventas", "ventas.id", "=", "ventas_detalle_pago.venta_id")
            ->where("ventas.fecha", date('Y-m-d'))
            ->where("ventas.eliminado", false)
            ->where("ventas.pago_completo", true)
            ->where("ventas_detalle_pago.tipopago_id", $debito_id)
            ->where("ventas_detalle_pago.eliminado",false) ; 
        $monto_completas = Ventas::select(\DB::raw("sum(total_recibido) as cantidad"))->where("ventas.fecha", date("Y-m-d"))->where("eliminado", false)  ->whereNotIN("tipopago_id",[2,3]) ; //->where("pago_completo", true);
        $monto_credito = VentaDetallePago::select(\DB::raw("sum(ventas_detalle_pago.monto) as cantidad"))
            ->leftjoin("ventas", "ventas.id", "=", "ventas_detalle_pago.venta_id")
            ->where("ventas.fecha", date('Y-m-d'))
            ->where("ventas.eliminado", false)
            ->where("ventas.pago_completo", true)
            ->where("ventas_detalle_pago.tipopago_id", $credito_id)
            ->where("ventas_detalle_pago.eliminado",false) ; 


        $monto_egreso =  Gasto::select(\DB::raw("sum(monto) as  cantidad"))->where("fecha", date('Y-m-d'))->where("eliminado", false);

        $ventas = Ventas::select('ventas.id', "ventas.detalle","ventas.cliente", "ventas.total_recibido","ventas.descuento_importe", "ventas.tipoenvio_id","ventas_estadoenvio.nombre as estadoenvio", \DB::raw("TO_CHAR(ventas.fecha, 'YYYY/MM/DD') fecha"), \DB::raw("to_char(ventas.hora,'HH24:MI') hora"), "tipopago.tipo_pago",  'ventas.monto',    'ventas.pago_completo')
            ->leftjoin("ventas_estadoenvio", "ventas_estadoenvio.id", "=", "ventas.tipoenvio_id")
            ->leftjoin("tipopago", "tipopago.id", "=", "ventas.tipopago_id")
            ->where('ventas.eliminado', false)
            ->where("ventas.fecha", date("Y-m-d"));


        if (date("H:i") >= $t1_hora_desde && date("H:i") <= $t1_hora_hasta) {
            $campana = true;
            $cantidad_completas = $cantidad_completas->where("ventas.hora", ">=", $t1_hora_desde)->where("ventas.hora", "<=", $t1_hora_hasta)->first();
            $monto_debito =  $monto_debito->where("ventas.hora", ">=", $t1_hora_desde)->where("ventas.hora", "<=", $t1_hora_hasta)->first();
            $monto_completas =   $monto_completas->where("ventas.hora", ">=", $t1_hora_desde)->where("ventas.hora", "<=", $t1_hora_hasta)->first();
            $monto_credito =   $monto_credito->where("ventas.hora", ">=", $t1_hora_desde)->where("ventas.hora", "<=", $t1_hora_hasta)->first();
            $monto_egreso = $monto_egreso->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI')   "), ">=", $t1_hora_desde)->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), "<=", $t1_hora_hasta)->first();
            $ventas = $ventas->where("ventas.hora", ">=", $t1_hora_desde)->where("ventas.hora", "<=", $t1_hora_hasta);
            $ventas = $ventas->orderby("ventas.id", 'desc')->get();
        }

        if(date("H:i")>=$t2_hora_desde && date("H:i")<= $t2_hora_hasta){
            $campana =true;
            $cantidad_completas =  $cantidad_completas->where("ventas.hora", ">=", $t2_hora_desde)->where("ventas.hora", "<=", $t2_hora_hasta)->first();
            $monto_debito =  $monto_debito->where("ventas.hora", ">=", $t2_hora_desde)->where("ventas.hora", "<=", $t2_hora_hasta)->first();
            $monto_completas = $monto_completas->where("ventas.hora", ">=", $t2_hora_desde)->where("ventas.hora", "<=", $t2_hora_hasta)->first();
            $monto_credito =   $monto_credito->where("ventas.hora", ">=", $t2_hora_desde)->where("ventas.hora", "<=", $t2_hora_hasta)->first();
            $monto_egreso = $monto_egreso ->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), ">=", $t2_hora_desde)->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), "<=", $t2_hora_hasta)->first();
            $ventas = $ventas->where("ventas.hora", ">=", $t2_hora_desde)->where("ventas.hora", "<=", $t2_hora_hasta);
            $ventas = $ventas->orderby("ventas.id", 'desc')->get();
        }

        
        if($campana == false)  $ventas = array();
        $cantidad_completas =  isset($cantidad_completas->cantidad) ? $cantidad_completas->cantidad: 0;
        $monto_completas = isset($monto_completas->cantidad) ? number_format($monto_completas->cantidad, 2, '.', '')  : 0;
        $monto_debito =  isset($monto_debito->cantidad) ?number_format($monto_debito->cantidad, 2, '.', '') : 0;
        $monto_credito = isset($monto_credito->cantidad) ? number_format($monto_credito->cantidad, 2, '.', '') : 0;
        $monto_egreso = isset($monto_egreso->cantidad) ? number_format($monto_egreso->cantidad, 2, '.', '') : 0;

        $total =   ($monto_completas) - $monto_egreso;


        return view("ventas.index", compact("ventas",  "cantidad_completas",   "monto_completas", "monto_debito", "monto_credito", "monto_egreso", "total"));
    }


    public function enviado(Request $request ){
        if(!request()->ajax()) return redirect()->route("ventas");
        
        $validator = \Validator::make($request->all(), [
            'id' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $id = request()->id ? request()->id: null; 
        $d = null;
        if($id){
            $d = Ventas::where("id",$id)->where("eliminado",false)->update([
                "tipoenvio_id" => 3, // enviado 
            ]);

            if($d){
                $data = array();
                $data["estado"] = "eliminar";
                $data["venta_id"] =  $id;
                $data["tipo"] =  "Marcar como enviado";
                $data["fecha"] = date("Y-m-d H:i") ;
                // generar evento de pedido
                try {
                    $options = array(
                        'cluster' => env("PUSHER_APP_CLUSTER"),
                        'encrypted' => true
                    );
                    $pusher = new Pusher(
                        env('PUSHER_APP_KEY'),
                        env('PUSHER_APP_SECRET'),
                        env('PUSHER_APP_ID'),
                        $options
                    );
                    $pusher->trigger('pedidos-pendientes', 'App\Events\EventoPedidos', $data );
                } catch (\Exception $th) {
                    // throw $th;
                    Log::error($th->getMessage());
                }
                // end generar evento de pedido
                // try {
                //     event(new EventoPedidos( $data));
                // } catch (\Exception $th) {
                //     //throw $th;
                //     Log::error($th->getMessage());
                // }
            }
        }

        if ($d) {
            return response()->json(["status" => "success",  "message" => "Guardado!", "data"=>$id]);
        }
        return response()->json(["status" => "error", "message" => "Error al guardar!"]);

    }

    public function filtro(Request $request)
    {
        if(!request()->ajax()) return redirect()->route("ventas");

        $validator = \Validator::make($request->all(), [
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date',
            // 'cliente' => 'nullable|numeric',
            'empleado' => 'nullable|numeric',
            'estadopago' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $fecha_desde = request()->fecha_desde !==null ? request()->fecha_desde : null;
        $fecha_hasta = request()->fecha_hasta !==null ? request()->fecha_hasta : null;
        // $cliente = (request()->cliente != 0) ? request()->cliente : null;
        $empleado = request()->empleado ? request()->empleado : null;
        $estadopago = request()->estadopago;

        if (request()->estadopago == 0) $estadopago = null;
        if (request()->estadopago == 1) $estadopago = true; // pago completo
        if (request()->estadopago == 2) $estadopago = false; // pago incompleto

        $ventas = Ventas::select('ventas.id',  \DB::raw("TO_CHAR(ventas.fecha, 'YYYY/MM/DD') fecha"), "ventas.total_recibido", 'ventas.hora', "ventas.cliente",  'ventas.monto',   'ventas.pago_completo')
            // ->join("cliente", "cliente.id", '=', 'ventas.cliente_id')
            ->where("ventas.fecha", date("Y-m-d"))
            ->where('ventas.eliminado', false);

        if ($fecha_desde !== null && $fecha_hasta !== null) {
            // $ventas = $ventas->whereBetween("ventas.fecha", [$fecha_desde, $fecha_hasta]);
            $ventas = $ventas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta);

        }
        if ($fecha_desde !== null && $fecha_hasta == null) {
            // $ventas = $ventas->whereBetween("ventas.fecha", [$fecha_desde, $fecha_desde]);
            $ventas = $ventas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde);

        }
        if ($fecha_desde == null && $fecha_hasta !== null) {
            $ventas = $ventas->whereBetween("ventas.fecha", [$fecha_hasta, $fecha_hasta]);
        }
        // if ($cliente !== null) {
        //     $ventas = $ventas->where("ventas.cliente_id", $cliente);
        // }
        if ($estadopago !== null) {
            $ventas = $ventas->where("ventas.pago_completo", $estadopago);
        }
        // if ($empleado) {
        //     // verificar rol empleado del user_id 
        //     $ventas = $ventas->where("ventas.user_id", $empleado);
        // }
        $ventas = $ventas->orderBy("ventas.updated_at", 'desc');
        $ventas = $ventas->paginate(15);

        return response()->json(view("ventas.index_data", compact("ventas"))->render());
    }




    public function listado()
    {

        $ayer =  date('Y-m-d', strtotime("-1 day"));
        $debito_id = 2; // tipo debito
        $credito_id = 3; // tipo credito
        $tipopagos =  TipoPago::select("id", "tipo_pago")->where("eliminado", false)->pluck("tipo_pago", "id");
        $tipo_envios = VentasEstadoEnvio::select("nombre","id") ->orderby("id","asc")->pluck("nombre","id");

        $cantidad_completas = Ventas::select(\DB::raw("count(*) as cantidad"))->where("ventas.fecha", $ayer) ->where("tipoenvio_id",3)->where("eliminado", false)->where("pago_completo", true)->first();
        $monto_debito = VentaDetallePago::select(\DB::raw("sum(ventas_detalle_pago.monto) as cantidad"))
            ->leftjoin("ventas", "ventas.id", "=", "ventas_detalle_pago.venta_id")
            ->where("ventas.fecha", $ayer)
            ->where("ventas.eliminado", false)
            ->where("ventas.pago_completo", true)
            ->where("ventas.tipoenvio_id",3)
            ->where("ventas_detalle_pago.tipopago_id", $debito_id) 
            ->where("ventas_detalle_pago.eliminado", false) 
            ->first();
        $monto_completas = Ventas::select(\DB::raw("sum(total_recibido) as cantidad"))->where("ventas.fecha", $ayer)->where("eliminado", false) ->where("tipoenvio_id",3) ->whereNotIN("tipopago_id",[2,3])->first(); //->where("pago_completo", true);
        $monto_credito = VentaDetallePago::select(\DB::raw("sum(ventas_detalle_pago.monto) as cantidad"))
            ->leftjoin("ventas", "ventas.id", "=", "ventas_detalle_pago.venta_id")
            ->where("ventas.fecha", $ayer)
            ->where("ventas.eliminado", false)
            ->where("ventas.pago_completo", true)
            ->where("ventas.tipoenvio_id",3)
            ->where("ventas_detalle_pago.tipopago_id", $credito_id)
            ->where("ventas_detalle_pago.eliminado", false)
            ->first();
        $monto_egreso =  Gasto::select(\DB::raw("sum(monto) as  cantidad"))->where("fecha", $ayer)->where("eliminado", false)->first();

        $cantidad_completas =  $cantidad_completas->cantidad;
        $monto_completas = number_format($monto_completas->cantidad, 2, '.', '');
        $monto_debito = number_format($monto_debito->cantidad, 2, '.', '');
        $monto_credito = number_format($monto_credito->cantidad, 2, '.', '');
        $monto_egreso = number_format($monto_egreso->cantidad, 2, '.', '');

        $total =   ($monto_completas) - $monto_egreso;

        $ventas = Ventas::select('ventas.id', "ventas.cliente", "ventas.descuento_importe", "ventas.total_recibido", "ventas.tipoenvio_id", "ventas_estadoenvio.nombre as estadoenvio", \DB::raw("TO_CHAR(ventas.fecha, 'YYYY/MM/DD') fecha"),  \DB::raw("to_char(ventas.hora,'HH24:MI') hora") ,"tipopago.tipo_pago",  'ventas.monto',    'ventas.pago_completo')
            ->leftjoin("ventas_estadoenvio", "ventas_estadoenvio.id", "=", "ventas.tipoenvio_id")
            ->leftjoin("tipopago", "tipopago.id", "=", "ventas.tipopago_id")
            ->where('ventas.eliminado', false)
            ->where("ventas.fecha", $ayer)
            ->orderby("ventas.id","desc")
            ->get();
        $render = false;

        return view("ventas.listado", compact("ventas", "tipo_envios" ,  "cantidad_completas",   "monto_completas", "monto_debito", "monto_credito", "monto_egreso", "total", "tipopagos", "render"));
    }



    public function filtroListado(Request $request)
    {

        if (!$request->ajax()) return redirect()->route("reportes");

        $validator = \Validator::make($request->all(), [
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date',
            'cliente' => 'nullable|numeric',
            'tipopago' => 'nullable|numeric',
            'empleado' => 'nullable|numeric',
            'estadopedido' => 'nullable|numeric',
            'estadopago' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }



        $fecha_minimo = new DateTime("2021-11-19");
        $fecha_desde = request()->fecha_desde!==null ? request()->fecha_desde : null;
        $fecha_hasta = request()->fecha_hasta !==null ? request()->fecha_hasta : null;
        $cliente = (request()->cliente != 0) ? request()->cliente : null;
        $empleado = request()->empleado ? request()->empleado : null;
        $tipopago = request()->tipopago < 0 ? null : request()->tipopago;
        $estadopedido = request()->estadopedido < 0 ? null:  request()->estadopedido;
        $estadopago = request()->estadopago < 0 ? null :  request()->estadopago;
        $pagina = request()->page >1 ? false : true;
        $debito_id = 2; // tipo debito
        $credito_id = 3; // tipo credito
        if (request()->estadopago == 0) $estadopago = null;
        if (request()->estadopago == 1) $estadopago = true; // pago completo
        if (request()->estadopago == 2) $estadopago = false; // pago incompleto

        $fecha_desde1 = new DateTime($fecha_desde);
        $fecha_hasta1 = new DateTime($fecha_hasta);

        $fd =  $fecha_desde1->diff($fecha_minimo);
        $fh =  $fecha_hasta1->diff($fecha_minimo);
        
        if($fd->days == 0 ) $fecha_desde ==null;
        if($fh->days == 0 ) $fecha_hasta =null;
 
 
        $cantidad_completas = Ventas::select(\DB::raw("count(*) as cantidad"))->where("eliminado", false)  ->where("tipoenvio_id",3);

        $monto_debito = VentaDetallePago::select(\DB::raw("sum(ventas_detalle_pago.monto) as cantidad"))
            ->leftjoin("ventas", "ventas.id", "=", "ventas_detalle_pago.venta_id")
            ->where("ventas.eliminado", false)
            ->where("ventas.tipoenvio_id", 3 )
            ->where("ventas_detalle_pago.tipopago_id", $debito_id)
            ->where("ventas_detalle_pago.eliminado", false) ; 
        $monto_completas = Ventas::select(\DB::raw("sum(total_recibido) as cantidad"))->where("eliminado", false) ->where("tipoenvio_id",3)->whereNotIN("tipopago_id",[2,3]) ; //->where("pago_completo", true);
        $monto_credito = VentaDetallePago::select(\DB::raw("sum(ventas_detalle_pago.monto) as cantidad"))
            ->leftjoin("ventas", "ventas.id", "=", "ventas_detalle_pago.venta_id")
            ->where("ventas.eliminado", false)
            ->where("ventas.tipoenvio_id",3)
            ->where("ventas_detalle_pago.tipopago_id", $credito_id)
            ->where("ventas_detalle_pago.eliminado", false); 
        $monto_egreso =  Gasto::select(\DB::raw("sum(monto) as  cantidad"))->where("eliminado", false);


        $ventas = Ventas::select('ventas.id', "ventas.cliente","ventas.descuento_importe", "ventas.total_recibido", "ventas_estadoenvio.nombre as estadoenvio",  \DB::raw("TO_CHAR(ventas.fecha, 'YYYY/MM/DD') fecha"),  \DB::raw("to_char(ventas.hora,'HH24:MI') hora") ,  'ventas.monto',    'ventas.pago_completo', "tipopago.tipo_pago")
            ->leftjoin("ventas_estadoenvio", "ventas_estadoenvio.id", "=", "ventas.tipoenvio_id")
            ->leftjoin("tipopago", "tipopago.id", "=", "ventas.tipopago_id")
            ->where('ventas.eliminado', false);

        if($estadopedido !==null) {
            $ventas = $ventas ->where('ventas.tipoenvio_id',$estadopedido);

        }


        if ($fecha_desde !== null && $fecha_hasta !== null) {
            // $ventas = $ventas->whereBetween(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD')     "), [$fecha_desde, $fecha_hasta]);
            $ventas = $ventas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta);
            if($pagina ){
                $cantidad_completas =  $cantidad_completas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
                $monto_debito = $monto_debito->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
                $monto_completas = $monto_completas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
                $monto_credito = $monto_credito->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
                $monto_egreso = $monto_egreso->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;

            }
        }
        if ($fecha_desde !== null && $fecha_hasta == null) {
            $ventas = $ventas->whereBetween(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), [$fecha_desde, $fecha_desde]);
            // $ventas = $ventas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_desde);
            if($pagina ){
                $cantidad_completas =  $cantidad_completas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_desde) ;
                $monto_debito = $monto_debito->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_desde) ;
                $monto_completas = $monto_completas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_desde) ;
                $monto_credito = $monto_credito->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_desde) ;
                $monto_egreso = $monto_egreso->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fecha_desde) ;
            }
        }
        if ($fecha_desde == null && $fecha_hasta !== null) {
            // $ventas = $ventas->whereBetween(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), [$fecha_hasta, $fecha_hasta]);
            $ventas = $ventas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta);
            if($pagina ){
                $cantidad_completas =  $cantidad_completas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
                $monto_debito = $monto_debito->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
                $monto_completas = $monto_completas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
                $monto_credito = $monto_credito->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
                $monto_egreso = $monto_egreso->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
            }

        }

        if ($fecha_desde == null && $fecha_hasta == null) {
            $fecha_desde = $fecha_hasta = date("Y-m-d");
            // $ventas = $ventas->whereBetween(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), [$fecha_hasta, $fecha_hasta]);
            $ventas = $ventas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta);
            $cantidad_completas =  $cantidad_completas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
            $monto_debito = $monto_debito->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
            $monto_completas = $monto_completas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
            $monto_credito = $monto_credito->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
            $monto_egreso = $monto_egreso->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fecha_hasta)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta) ;
        }
       

        if ($cliente !== null) {
            $ventas = $ventas->where("ventas.cliente_id", $cliente);
        }
        if ($tipopago !== null) {
            $ventas = $ventas ->where("ventas.tipopago_id", $tipopago);
            if($pagina){
                $cantidad_completas =  $cantidad_completas  ->where("ventas.tipopago_id", $tipopago); 
                $monto_completas = $monto_completas ->where("ventas.tipopago_id", $tipopago);
                $monto_debito = $monto_debito ->where("ventas.tipopago_id", $tipopago) ;
                $monto_credito = $monto_credito  ->where("ventas.tipopago_id", $tipopago) ;
                $monto_egreso = $monto_egreso ->where("gasto.tipopago_id", $tipopago);
            }
        }

        if ($estadopago !== null) {
            $ventas = $ventas->where("ventas.pago_completo", $estadopago);
            if($pagina){
                $cantidad_completas =  $cantidad_completas   ->where("ventas.pago_completo", $estadopago) ; 
                $monto_debito = $monto_debito ->where("ventas.pago_completo", $estadopago) ;
                $monto_completas = $monto_completas ->where("ventas.pago_completo", $estadopago) ;
                $monto_credito = $monto_credito  ->where("ventas.pago_completo", $estadopago) ;
            }
        }
        if ($empleado) {
            // verificar rol empleado del user_id 
            $ventas = $ventas->where("ventas.user_id", $empleado);
        }

        $ventas = $ventas->orderBy("ventas.id", 'desc')  ->paginate(15);
        $render = true;

        $data = array();
        if($pagina){
            $cantidad_completas =  $cantidad_completas->first();
            $monto_completas =  $monto_completas  ->first();
            $monto_debito = $monto_debito ->first();
            $monto_credito =   $monto_credito ->first();
            $monto_egreso = $monto_egreso ->first();

            $cantidad_completas =  $cantidad_completas->cantidad;
            $monto_completas = number_format($monto_completas->cantidad, 2, '.', '');
            $monto_debito = number_format($monto_debito->cantidad, 2, '.', '');
            $monto_credito = number_format($monto_credito->cantidad, 2, '.', '');
            $monto_egreso = number_format($monto_egreso->cantidad, 2, '.', '');
            $total =    number_format(($monto_completas - $monto_egreso),2,'.','');
    
            $data["cantidad_completas"] =  $cantidad_completas;
            $data["monto_completas"] =  $monto_completas;
            $data["monto_debito"] =  $monto_debito;
            $data["monto_credito"] =  $monto_credito;
            $data["monto_egreso"] =  $monto_egreso;
            $data["total"] =  $total;
    
        }


        return response()->json([view("ventas.listado_data_filtro", compact("ventas", "render"))->render(),$data]);
    }











    public function nuevo()
    {

        // $empleados = null;
        // if (auth()->user()->es_empleado == false) {
        //     $empleados = User::select("id", "nombre")->where("eliminado", false)->where("es_empleado", true)->pluck("nombre", "id");
        // }
        // $clientes = Cliente::select("id", "nombre")->where("eliminado", false)->pluck("nombre", "id");
        // 1	"Ordenado"
        // 2	"En preparacion"
        // 3	"Enviado"
        // 4	"Cancelado"
        $tipo_envios  = VentasEstadoEnvio::select("id", "nombre")->where("id", 2)->orderby("id", "asc")->pluck("nombre", "id");
        $tipo_pagos =  TipoPago::select("tipo_pago", "id")->where("eliminado", false)->pluck("tipo_pago", "id");
        $articulos = Articulo::select("id", 'articulo',"nombre_corto", 'stock', 'precio_venta',"categoria_id")
            // ->where("habilitado", true)
            ->where("eliminado", false) ->orderby("id","asc")->get();
        

        return view("ventas.nuevo", compact( "articulos",   "tipo_envios", "tipo_pagos"));
    }



    public function edit($id)
    {

        // $data = [
        //     'titulo' => 'Styde.net'
        // ];
        // $pdf = PDF::loadView('ventas.ticket', $data)  //->output();
        // ->setPaper('b7', 'portrait')->stream();
        // return $pdf;
        // return $pdf->download('mi-archivo.pdf');
        // $empleados = null;

        $venta = Ventas::select('id', 'fecha', "cliente", 'monto', \DB::raw("(monto-descuento_importe) as total_apagar"),   "descuento_importe", "comentario", "tipoenvio_id")
            ->where('eliminado', false)
            ->where("id", $id)
            ->first();
        if (!$venta) {
            return redirect()->route("ventas");
        }
        

        // $bebidas = Articulo::select("id", 'articulo', 'stock', 'precio_venta')
        //     ->where("habilitado", true)
        //     ->where("categoria_id", 1)
        //     ->where("eliminado", false)->get()->toArray();

            
        // $empanadas = Articulo::select("articulos.id", 'articulos.articulo', 'articulos.stock', 'articulos.precio_venta' )
        //     ->where("articulos.categoria_id", 2)
        //     ->where("articulos.eliminado", false)->get()->toArray();

        $articulos = Articulo::select("articulos.id", 'articulos.articulo', 'articulos.stock', 'articulos.precio_venta',"categoria_id" )
            ->where("articulos.eliminado", false)->orderby("id","asc")->get()->toArray();
            
        // 1	"Ordenado"
        // 2	"En preparacion"
        // 3	"Enviado"
        // 4	"Cancelado"
        // 5    "Entregado"
        $tipo_envios  = VentasEstadoEnvio::select("id", "nombre")->where("eliminado",false)->whereIn("id", [3, 4, 5])->orderby("id", "asc")->pluck("nombre", "id");
        $tipo_pagos =  TipoPago::select("tipo_pago", "id")->where("eliminado", false)->pluck("tipo_pago", "id");

        // if (auth()->user()->es_empleado == false) {
        //     $empleados = User::select("id", "nombre")->where("eliminado", false)->where("es_empleado", true)->pluck("nombre", "id");
        // }

        $detalles = VentaDetalleArticulo::select("cantidad","articulo_id as id"  )
        ->where("venta_id", $id)
        ->where("eliminado", false)->get()->toarray();;


        foreach ($detalles as $key => $value) {
            foreach ($articulos as $k => $v ) {
                if($value["id"] == $v["id"]){
                    $articulos[$k]["cantidad"] = $value["cantidad"];
                }
            }
        }
       
        $pagos = VentaDetallePago::select("ventas_detalle_pago.id","ventas_detalle_pago.monto", "tipopago.tipo_pago" )
            ->leftjoin("tipopago", "tipopago.id", "=", "ventas_detalle_pago.tipopago_id")
            ->where("tipopago.eliminado", false)
            ->where("ventas_detalle_pago.eliminado", false)
            ->where("ventas_detalle_pago.venta_id", $id)
            ->get();


        return view("ventas.edit", compact("venta", "articulos", "detalles", "pagos", "articulos",   "tipo_envios", "tipo_pagos"));
    }



    public function show(Request $request, $id)
    {

        // $data = [
        //     'titulo' => 'Styde.net'
        // ];
        // $pdf = PDF::loadView('ventas.ticket', $data)  //->output();
        // ->setPaper('b7', 'portrait')->stream();
        // return $pdf;
        // return $pdf->download('mi-archivo.pdf');

        $venta = Ventas::select(\DB::raw("TO_CHAR(ventas.fecha, 'YYYY/MM/DD') fecha"), "ventas.cliente", 'ventas.monto', "ventas_estadoenvio.nombre as estado_envio", \DB::raw("(ventas.monto-ventas.descuento_importe) as total_apagar"),   "users.nombre as user_nombre", 'ventas.descuento_porcentaje', "ventas.descuento_importe", "ventas.comentario", "ventas.pago_completo")
            ->leftjoin("ventas_estadoenvio", "ventas_estadoenvio.id", "=", "ventas.tipoenvio_id")
            ->leftjoin("users", "users.id", "=", "ventas.user_id")
            ->where("ventas.id", $id)
            ->where("ventas.eliminado",false)
            ->first();
        if (!$venta && $request->ajax()) {
            return response()->json(["status" => "success", "message" => "Venta no existe!"]);
        }
        if (!$venta) {
            return redirect()->route("ventas");
        }

        $detalles = VentaDetalleArticulo::select("cantidad", "subtotal", "descuento", "articulo", "precio", "articulo_id", "id")->where("venta_id", $id)->where("eliminado", false)->get();
        $pagos = VentaDetallePago::select("ventas_detalle_pago.monto", "tipopago.tipo_pago")
            ->leftjoin("tipopago", "tipopago.id", "=", "ventas_detalle_pago.tipopago_id")
            ->where("ventas_detalle_pago.venta_id", $id)->where("ventas_detalle_pago.eliminado", false)->get();

        if (!empty($venta) && $request->ajax()) {
            return response()->json(view("ventas.detalles_data", compact("venta", "detalles", "pagos"))->render());
        }

        return view("ventas.detalles", compact("venta", "detalles", "pagos"));
    }






    public function update(Request $request, $id)
    {

        $venta = Ventas::select("id")->where("id", $id)->where("eliminado",false)->first();
        if (!$venta) {
            return response()->json(["status" => "error", "message" => "Venta no existe!"]);
        }
        $validator = \Validator::make($request->all(), [
            'cliente' => 'nullable|string',
            'estadopedido_id' => 'nullable|numeric',
            // 'vendedor' => 'nullable|numeric',
            'fecha' => 'nullable|date',
            'articulos' => 'nullable|array',
            'descuento' => 'nullable|numeric',
            'pagos_id' => 'nullable|numeric',
            'pagos_monto' => 'nullable|numeric',
            'comentario' => 'nullable|string|max:2000',
            'ticket' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        
        $user_id = auth()->user()->id;
        $dataEvento = array();
        $cliente =  request()->cliente  ? trim($request->cliente) : null;
        $tipoenvio_id =  ( (int)request()->estadopedido_id > 0) ? (int)$request->estadopedido_id : null; // 1-ordenado, 2-enpreparacion, 3-enviado, 4-cancelado
        $vendedor_id =  request()->vendedor  ? $request->vendedor : null;
        $fecha =  request()->fecha  ? $request->fecha : date("Y-m-d");
        $articulos = request()->articulos ? request()->articulos : null;
        $descuento = request()->descuento ? request()->descuento : 0;
        
        $pagos_id =  (int)request()->pagos_id >= 1? (int)request()->pagos_id: null;
        $pagos_monto = ((float)trim(request()->pagos_monto) > 0) ? (float)request()->pagos_monto : null;

        $comentario = request()->comentario ? request()->comentario : null;
        $ticket = (boolean)request()->ticket == true ? true : false;
 
         
        if($cliente){
            // $cliente =  Purifier::clean($cliente);
            // $cliente = str_replace("&lt","",$cliente);
            // $cliente = str_replace("?","",$cliente);
            // $cliente = str_replace("\\","",$cliente);
            $cliente = str_replace("--","",$cliente);
            $cliente = str_replace("'","",$cliente);
            $cliente = trim($cliente);
        }
         
        if($comentario){
            // $comentario =  Purifier::clean($comentario);
            // $comentario = str_replace("&lt","",$comentario);
            // $comentario = str_replace("?","",$comentario);
            // $comentario = str_replace("\\","",$comentario);
            $comentario = str_replace("--","",$comentario);
            $comentario = str_replace("'","",$comentario);
            $comentario = trim($comentario);
        }



        if ($articulos) {
            $monto = null;
        }
        $data = array();
        $data["user_id"] = $user_id;
        $data["fecha"] =  $fecha;
        $data["hora"] =  date('H:i');

        $data["cliente"] = $cliente;
        $data["descuento_importe"]  = $descuento;
 
        // if ($vendedor_id) {
        //     $vendedor = User::select("nombre")->where("id", $vendedor_id)->where("es_empleado", true)->where("eliminado", false)->first();
        //     if (!$vendedor) {
        //         return response()->json(["status" => "error", "message" => "Vendedor no existe!"]);
        //     }
        //     $data["user_id"] = $vendedor_id;
        // }
        // if ($vendedor_id == null && auth()->user()->es_empleado == true) {
        //     $vendedor_id = auth()->user()->id;
        // }

        if ($comentario) {
            $data["comentario"] = $comentario;
        }
        if ($tipoenvio_id) {
            $data["tipoenvio_id"] = $tipoenvio_id;
        }
        if ($pagos_id > 0) {
            $data["tipopago_id"] = $pagos_id;
        }
        
        $restaurar_stock=true;
       
        $t1_hora_desde = "07:30";
        $t1_hora_hasta = "16:00";

        $t2_hora_desde = "16:01";
        $t2_hora_hasta = "23:59";


        // 'id','fecha','punto_venta','codigo','cliente_id','user_id','monto','descuento_porcentaje',
        // 'descuento_importe','cae','comentario','eliminado','creator_id',"caja_id",'created_at','updated_at'
        $total = Ventas::select("total_recibido", "descuento_importe", "tipoenvio_id")->where("id", $id)->where("eliminado", false)->first();
        if ($total) {
            if($total->tipoenvio_id == 4) $restaurar_stock =  false;
            // decrementar de reportes 
            $mes_fecha = date("m", strtotime($fecha));
            $anio_fecha = date("Y", strtotime($fecha));
            $monto = $total->total_recibido;

            Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_ventas", $monto);
            Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("cantidad_ventas", 1);
        }

        $venta = Ventas::where("id", $id)->where("eliminado", false)->update($data);
        $venta_id = $id;

        if($tipoenvio_id==4  && $restaurar_stock ){
            // 4- cancelar - entonces restaurar stock
            $venta_detalles = VentaDetalleArticulo::select("cantidad", "articulo_id")->where("venta_id", $id)->where("eliminado",false)->get();
            if ($venta_detalles) {
                foreach ($venta_detalles as $vd) {
                    $cant_art = (int)$vd["cantidad"];
                    Articulo::where("id", $vd["articulo_id"])->where("eliminado",false)->increment("stock", $cant_art);
                }
            }
        }

        $total = 0;
        $detalle ="";
        if ($articulos!==null && $tipoenvio_id!==4) {
            $venta_detalles = VentaDetalleArticulo::select("cantidad", "articulo_id")->where("venta_id", $id)->where("eliminado",false)->get();
            if ($venta_detalles) {
                foreach ($venta_detalles as $vd) {
                    $cant_art = (int)$vd["cantidad"];
                    Articulo::where("id", $vd["articulo_id"])->where("eliminado",false)->increment("stock", $cant_art);

                    // BEGIN ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 
                    $dia = date("d");
                    $mes = date("m");
                    $anio = date("Y");
                    if(date("H:i") >= $t1_hora_desde && date("H:i")<= $t1_hora_hasta ){
                        ArticuloPorDia::firstOrCreate(["articulo_id"=> $vd["articulo_id"],"dia"=>$dia,"mes" => $mes, "anio" => $anio, "t1" => true]);
                        ArticuloPorDia::where("dia",$dia)->where("mes",$mes )->where("anio",  $anio)->where("t1",true)->where("articulo_id",$vd["articulo_id"])->where("cantidad",'>',0)->decrement("cantidad", $cant_art);
                    }

                    if(date("H:i") >= $t2_hora_desde && date("H:i")<= $t2_hora_hasta ){
                        ArticuloPorDia::firstOrCreate(["articulo_id"=> $vd["articulo_id"],"dia"=>$dia,"mes" => $mes, "anio" => $anio, "t2" => true]);
                        ArticuloPorDia::where("dia",$dia)->where("mes",$mes )->where("anio",  $anio)->where("t2",true)->where("articulo_id",$vd["articulo_id"])->where("cantidad",">",0)->decrement("cantidad", $cant_art);
                    }
                    // END ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 
                }
                VentaDetalleArticulo::where("venta_id", $venta_id)->update(["eliminado"=>true]);
            }
            foreach ($articulos as $item) {
                $articulo_id  =  (isset($item["articulo_id"]) && $item["articulo_id"] !== null) ? trim($item["articulo_id"]) : null;
                $cantidad = (isset($item["articulo_cantidad"]) && $item["articulo_cantidad"] !== null) ? trim( $item["articulo_cantidad"]) : 1;
                // $descuento = (isset($item["articulo_descuento"]) && $item["articulo_descuento"] !== null) ?  $item["articulo_descuento"] : null;

                if ($articulo_id == null) continue;
                if($cantidad <= 0) continue;
                // 'id', 'articulo', 'codigo', 'codigo_barras', 'stock', 'stock_minimo',  'precio_compra','precio_venta','precio_neto_venta',
                // 'marca_id','categoria_id', 'subcategoria_id', 'tasa_iva_id', 'precio_id', 'creator_id',
                // 'habilitado', 'eliminado', 'created_at', 'updated_at'
                $articulo =  Articulo::select("articulo", "precio_venta", "stock")
                    ->where("id", $item['articulo_id'])
                    ->where("eliminado", false)
                    ->first();
                if (!$articulo) continue; // si no existe producto continua el blucle
                $precio_venta = (float)$articulo["precio_venta"];
                $subtotal =  $cantidad * $precio_venta;
                $nombre_articulo = trim($articulo['articulo']);
                // if ($descuento) {
                //     $subtotal =  $subtotal - ($subtotal * $descuento / 100);
                // }
                // id','venta_id','articulo_id','articulo','cantidad','subtotal',  'creator_id','eliminado','created_at','updated_at'
                $venta_detalle = VentaDetalleArticulo::create([
                    "cantidad" => $cantidad,
                    "precio" => $precio_venta,
                    "subtotal" => $subtotal,
                    // "descuento" => $descuento,
                    "articulo" => $nombre_articulo,
                    "articulo_id" => $articulo_id,
                    "venta_id" => $venta_id,
                    "user_id" => $user_id,
                ]);

                // BEGIN ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 
                $dia = date("d");
                $mes = date("m");
                $anio = date("Y");
                if(date("H:i") >= $t1_hora_desde && date("H:i")<= $t1_hora_hasta ){
                    ArticuloPorDia::firstOrCreate(["articulo_id"=> $articulo_id,"dia"=>$dia,"mes" => $mes, "anio" => $anio, "t1" => true]);
                    ArticuloPorDia::where("dia",$dia)->where("mes",$mes )->where("anio",  $anio)->where("t1",true)->where("articulo_id",$articulo_id)->increment("cantidad", $cantidad);
                }

                if(date("H:i") >= $t2_hora_desde && date("H:i")<= $t2_hora_hasta ){
                    ArticuloPorDia::firstOrCreate(["articulo_id"=> $articulo_id,"dia"=>$dia,"mes" => $mes, "anio" => $anio, "t2" => true]);
                    ArticuloPorDia::where("dia",$dia)->where("mes",$mes )->where("anio",  $anio)->where("t2",true)->where("articulo_id",$articulo_id)->increment("cantidad", $cantidad);
                }
                // END ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 


                
                $detalle .= "$cantidad $nombre_articulo,,";
                // decrementar  stock 
                if ($venta_detalle && $articulo["stock"] > 0) {
                    $articulo =  Articulo::where("id", $articulo_id)
                        ->where("eliminado", false)
                        ->decrement("stock", $cantidad);
                }
                // $errors[] = array(["message" => "Articulo " . $item['articulo_id'] . " stock insuficiente!"]);
                $total =  $total + $subtotal;
            } // end foreach
            // descuento general
            // if (isset($data["descuento_porcentaje"]) && !empty($data["descuento_porcentaje"])) {
            //     $total = $total - ($total * ($data["descuento_porcentaje"] / 100));
            // }
           $detalle .=",,,";
           $detalle = str_replace(",,,,,","",$detalle);
            Ventas::where("id", $venta_id)
                ->where("eliminado", false)
                ->update(["monto" => $total,"detalle"=>$detalle]);
        }

       

        if($tipoenvio_id!==4){
            // 4 - cancelado
            $total_apagar = $total;
            if ($descuento) {
                $total_apagar = $total - $descuento;
            }
    
            $mes_fecha = date("m", strtotime($fecha));
            $anio_fecha = date("Y", strtotime($fecha));
            Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("monto_ventas", $total_apagar);
            Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("cantidad_ventas", 1);

        }
 
        if($tipoenvio_id ==  4 || $tipoenvio_id == "4" &&   $fecha == date("Y-m-d")  ){
            $dataPuher = array();
            $dataPuher["metodo"] = "update";
            $dataPuher["estado"] = "eliminar";
            $dataPuher["venta_id"] =  $venta_id;
            // generar evento de pedido
            try {
                $options = array(
                    'cluster' => env("PUSHER_APP_CLUSTER"),
                    'encrypted' => true
                );
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );
                $pusher->trigger('pedidos-pendientes', 'App\Events\EventoPedidos', $dataPuher );
                //code...
            } catch (\Exception $th) {
                Log::error($th->getMessage());
            }
            // end generar evento de pedido
            // try {
            //     event(new EventoPedidos( $dataPuher));
            // } catch (\Exception $th) {
            //     //throw $th;
            //     Log::error($th->getMessage());
            // }
        }
        $suma = 0;
        if ($pagos_id && $pagos_monto) {
            $venta_pago = VentaDetallePago::create([
                "tipopago_id" => $pagos_id,
                "monto" => $pagos_monto,
                "venta_id" => $venta_id,
                // "creator_id" => $user_id,
            ]);
            Ventas::where("id", $venta_id)->where("eliminado", false)->increment("total_recibido", $pagos_monto);
            $suma += $pagos_monto;
            
            $vdp = VentaDetallePago::select(\DB::raw("sum(monto) as monto"))->where("venta_id", $venta_id)->first();
            $suma += $vdp->monto;
            if ($suma >= $total) {
                Ventas::where("id", $venta_id)
                    ->where("eliminado", false)
                    ->update(["pago_completo" => true]);
            }
        }





        if ($ticket == true) {
            $empresa = array(
                "nombre" => "EMPTATODO EMPANADA",
            );
            $venta = Ventas::where("id", $venta_id)->first();
            $detalles =  VentaDetalleArticulo::where("venta_id", $venta_id)->where("eliminado",false)->get();
            $pagos = VentaDetallePago::select("ventas_detalle_pago.monto", "tipopago.tipo_pago")
                ->leftjoin("tipopago", "tipopago.id", "=", "ventas_detalle_pago.tipopago_id")
                ->where("tipopago.eliminado", false)
                ->where("ventas_detalle_pago.eliminado", false)
                ->where("venta_id", $venta_id)
                ->get();
            // $logo = Empresa::select("thumbnail")->first();
            // $path = public_path("images/thumbnail/").$logo->thumbnail;
            $path = public_path("images/logo.jpg");
            if (file_exists($path)) {
                $logo = "images/logo.jpg";
            }
            $path_file = $this->ticket($venta, $detalles, $pagos, $empresa, $logo);
            $path = "fpdf/fpdf_ticket.pdf";
            $path =   public_path($path);
            $pdf = file_get_contents($path);
            $data = base64_encode($pdf);

            return response()->json(["status" => "success",   "message" => "Guardado!", "data" => $data]);
        }
        if ($venta) {
            return response()->json(["status" => "success", "message" => "Editado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error !"]);
    } // end editar

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //'id','fecha','punto_venta','codigo','cliente_id','user_id','monto','descuento_porcentaje',
        // 'descuento_importe','eliminado','creator_id','created_at','updated_at'
        $validator = \Validator::make($request->all(), [
            'cliente' => 'nullable|string',
            'envio' => 'nullable|numeric',
            // 'vendedor' => 'nullable|numeric',
            'fecha' => 'nullable|date',
            'articulos' => 'required|array',
            'descuento' => 'nullable|numeric',
            'pagos_id' => 'nullable|numeric',
            'pagos_monto' => 'nullable|numeric',
            'comentario' => 'nullable|string|max:2000',
            // 'factura' => 'nullable|string',
            'ticket' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $user_id = auth()->user()->id;

        $dataEvento = array(); // array para pasarle al evento
        $cliente =  request()->cliente  ? trim($request->cliente) : null;
        $tipoenvio_id =  (request()->envio > 0) ? $request->envio : 2; // 1-ordenado, 2-enpreparacion, 3-enviado, 4-cancelado
        // $vendedor_id =  request()->vendedor  ? $request->vendedor : null;
        $fecha =  request()->fecha  ? $request->fecha : date("Y-m-d");
        $articulos = request()->articulos ? request()->articulos : null;
        $descuento = request()->descuento !==null? request()->descuento : 0;
        $pagos_id =  (int)request()->pagos_id >= 1? (int)request()->pagos_id: null;
        $pagos_monto = ((float)trim(request()->pagos_monto) > 0) ? (float)request()->pagos_monto : null;
        $comentario = request()->comentario ? request()->comentario : null;
        // $factura = (request()->factura === 'true') ? true : false;
        $ticket = (boolean) request()->ticket == true ?(boolean) request()->ticket: false;
        // $pagos metodopago_id, monto
        // return response()->json(["status" => "success","art"=>$arr, "message" => "Venta creado correctamente!"]);
        
        if($cliente){
            // $cliente =  Purifier::clean($cliente);
            // $cliente = str_replace("&lt","",$cliente);
            // $cliente = str_replace("?","",$cliente);
            // $cliente = str_replace("\\","",$cliente);
            $cliente = str_replace("--","",$cliente);
            $cliente = str_replace("'","",$cliente);
            $cliente = trim($cliente);
        }
         
        if($comentario){
            // $comentario =  Purifier::clean($comentario);
            // $comentario = str_replace("&lt","",$comentario);
            // $comentario = str_replace("?","",$comentario);
            // $comentario = str_replace("\\","",$comentario);
            $comentario = str_replace("--","",$comentario);
            $comentario = str_replace("'","",$comentario);
            $comentario = trim($comentario);
        }


        $t1_hora_desde = "07:30";
        $t1_hora_hasta = "16:00";

        $t2_hora_desde = "16:01";
        $t2_hora_hasta = "23:59";
        $campana = false;
        

        if ($articulos) {
            $monto = null;
        }
        $hora = date("H:i");
        $data = array();
        $data["user_id"] = $user_id;
        $data["fecha"] =  $fecha;
        $data["hora"] = $hora;
        $data["cliente"] = $cliente;
        $data["tipoenvio_id"] =  3;  // enviado

        if($fecha == date("Y-m-d")){
            $data["tipoenvio_id"] =  2;  // en preparacion

        }

        $data["descuento_importe"]  = 0;
        $dataEvento["metodo"] = "store";
        $dataEvento["estado"] = "agregar";
        $dataEvento["cliente"] = $cliente;
        // if ($cliente) {
        //     $cliente = Cliente::select("nombre")->where("id", $cliente_id)->where("id", "<>", "1")->first();
        //     if (!$cliente) {
        //         return response()->json(["status" => "error", "message" => "Cliente no existe!"]);
        //     }
        //     $data["cliente_id"] = $cliente_id;
        // }

        // if ($vendedor_id) {
        //     $vendedor = User::select("nombre")->where("id", $vendedor_id)->where("es_empleado", true)->where("eliminado", false)->first();
        //     if (!$vendedor) {
        //         return response()->json(["status" => "error", "message" => "Vendedor no existe!"]);
        //     }
        //     $data["user_id"] = $vendedor_id;
        // }
        // if ($vendedor_id == null && auth()->user()->es_empleado == true) {
        //     $vendedor_id = auth()->user()->id;
        // }

        if ($descuento) {
            $data["descuento_importe"] = $descuento; 
 
        }
        if ($comentario) {
            $data["comentario"] = $comentario;
        }

        // if ($tipoenvio_id) {
        //     $data["tipoenvio_id"] = $tipoenvio_id;
        // }
        if ($pagos_id > 0) {
            $data["tipopago_id"] =  $pagos_id;
        }
        // if ($factura == true && $ticket == true) {
        //     $factura = true;
        //     $ticket = false;
        // }
        // 'id','fecha','punto_venta','codigo','cliente_id','user_id','monto','descuento_porcentaje',
        // 'descuento_importe','cae','comentario','eliminado','creator_id',"caja_id",'created_at','updated_at'
        $venta = Ventas::create($data);
        $venta_id = $venta->id;
        // return response()->json([$venta]);
        $dataEvento["venta_id"] = $venta_id;
        $dataEvento["created_at"] = $fecha . " " . $hora;
        $dataEvento["articulos"] = array();
        $total = 0;
        $detalle = "";
        if ($articulos) {
            // articulo_id: articulo_id,
            // articulo_cantidad: articulo_cantidad,
            // articulo_descuento: articulo_descuento
            foreach ($articulos as $item) {
                $articulo_id  =  (isset($item["articulo_id"]) && $item["articulo_id"] !== null) ? $item["articulo_id"] : null;
                $cantidad = (isset($item["articulo_cantidad"]) && $item["articulo_cantidad"] !== null) ?  $item["articulo_cantidad"] : 1;
                // $descuento = (isset($item["articulo_descuento"]) && $item["articulo_descuento"] !== null) ?  $item["articulo_descuento"] : null;

                if ($articulo_id == null) continue;
                if($cantidad <=0) continue;
                
                // 'id', 'articulo', 'codigo', 'codigo_barras', 'stock', 'stock_minimo',  'precio_compra','precio_venta','precio_neto_venta',
                // 'marca_id','categoria_id', 'subcategoria_id', 'tasa_iva_id', 'precio_id', 'creator_id',
                // 'habilitado', 'eliminado', 'created_at', 'updated_at'
                $articulo =  Articulo::select("articulo", "precio_venta", "stock", "stock_minimo")
                    ->where("id", $item['articulo_id'])
                    ->where("eliminado", false)
                    ->first();


                if (!$articulo) continue; // si no existe producto continua el blucle
                $stock = $articulo->stock;
                $stock_minimo = $articulo->stock_minimo;
                $stock_total = $stock - $cantidad;
                $articulo_nombre = $articulo->articulo;

                $detalle .="$cantidad $articulo_nombre,,";
                $precio_venta = (float)$articulo["precio_venta"];
                $subtotal =  $cantidad * $precio_venta;
                // if ($descuento) {
                //     $subtotal =  $subtotal - ($subtotal * $descuento / 100);
                // }

                // id','venta_id','articulo_id','articulo','cantidad','subtotal',  'creator_id','eliminado','created_at','updated_at'
                $venta_detalle = VentaDetalleArticulo::create([
                    "cantidad" => $cantidad,
                    "precio" => $precio_venta,
                    "subtotal" => $subtotal,
                    // "descuento" => $descuento,
                    "articulo" => $articulo['articulo'],
                    "articulo_id" => $articulo_id,
                    "venta_id" => $venta_id,
                    "user_id" => $user_id,
                ]);


                // BEGIN ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 
                $dia = date("d");
                $mes = date("m");
                $anio = date("Y");
                if(date("H:i") >= $t1_hora_desde && date("H:i")<= $t1_hora_hasta ){
                    ArticuloPorDia::firstOrCreate(["articulo_id"=> $articulo_id,"dia"=>$dia,"mes" => $mes, "anio" => $anio, "t1" => true]);
                    ArticuloPorDia::where("dia",$dia)->where("mes",$mes )->where("anio",  $anio)->where("t1",true)->where("articulo_id",$articulo_id)->increment("cantidad", $cantidad);
                }

                if(date("H:i") >= $t2_hora_desde && date("H:i")<= $t2_hora_hasta ){
                    ArticuloPorDia::firstOrCreate(["articulo_id"=> $articulo_id,"dia"=>$dia,"mes" => $mes, "anio" => $anio, "t2" => true]);
                    ArticuloPorDia::where("dia",$dia)->where("mes",$mes )->where("anio",  $anio)->where("t2",true)->where("articulo_id",$articulo_id)->increment("cantidad", $cantidad);
                }
                // END ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 

                array_push($dataEvento["articulos"], array(
                    "cantidad" => $cantidad,
                    "articulo" => $articulo['articulo'],
                ));

                // decrementar  stock 
                if ($venta_detalle && $articulo["stock"] > 0) {
                    $articulo =  Articulo::where("id", $articulo_id)
                        ->where("eliminado", false)
                        ->decrement("stock", $cantidad);
                }
                // stock minimo
                if ($stock_total <= $stock_minimo) {
                    $message = "El articulo " . trim($articulo_nombre) . " se esta quedando sin stock.!";
                    $nota = "Stock actual: " . $stock_total;
                    Notificacion::create([
                        "descripcion" => $message . " " . $nota,
                        // "nota" => $nota,
                        "articulo_id" => $articulo_id,
                        "user_id" => $user_id,
                    ]);
                }

                // $errors[] = array(["message" => "Articulo " . $item['articulo_id'] . " stock insuficiente!"]);
                $total =  $total + $subtotal;
            } // end foreach
            // descuento general
            // if (isset($data["descuento_porcentaje"]) && !empty($data["descuento_porcentaje"])) {
            //     $total = $total - ($total * ($data["descuento_porcentaje"] / 100));
            // }
            $detalle .=",,,";
            $detalle = str_replace(",,,,,","",$detalle);
            Ventas::where("id", $venta_id)
                ->where("eliminado", false)
                ->update(["monto" => $total,"detalle"=>$detalle]);
            
            if (isset($data["descuento_importe"]) && !empty($data["descuento_importe"])) {
                $total = $total - $data["descuento_importe"];
            }
          

            // si caja abierta incrementar monto_estimado
            // $caja_abierta = CajasDetalle::where('caja_abierta', true)->increment("monto_estimado", $total);
            // reportes 
            $mes_fecha = date("m", strtotime($fecha));
            $anio_fecha = date("Y", strtotime($fecha));
            Reportes::firstOrCreate(["mes" => $mes_fecha, "anio" => $anio_fecha, "eliminado" => false]);
            Reportes::where("mes",$mes_fecha )->where("anio",  $anio_fecha)->increment("monto_ventas", $total);
            Reportes::where("mes",$mes_fecha )->where("anio",  $anio_fecha)->increment("cantidad_ventas", 1);
        }

        $suma = 0;

        if ($pagos_id && $pagos_monto ) {
            $venta_pago = VentaDetallePago::create([
                "tipopago_id" => $pagos_id,
                "monto" => $pagos_monto,
                "venta_id" => $venta_id,
                // "creator_id" => $user_id,
            ]);
            Ventas::where("id", $venta_id)->where("eliminado", false)->increment("total_recibido", $pagos_monto);
            $suma += $pagos_monto;
        }

        $vdp = VentaDetallePago::select(\DB::raw("sum(monto) as monto"))->where("venta_id", $venta_id)->first();
        $suma = $vdp->monto;
        if ($suma >= $total) {
            Ventas::where("id", $venta_id)
                ->where("eliminado", false)
                ->update(["pago_completo" => true]);
        }

        // 1	"Ordenado"
        // 2	"En preparacion"
        // 3	"Enviado"
        // 4	"Cancelado"
        // generar evento de pedido
        if($fecha == date("Y-m-d")){
            if (date("H:i") >= $t1_hora_desde && date("H:i") <= $t1_hora_hasta ||  date("H:i")>=$t2_hora_desde && date("H:i")<= $t2_hora_hasta) {
                if (in_array($data["tipoenvio_id"], array(1, 2))) {
                   try {
                       $options = array(
                            'cluster' => env("PUSHER_APP_CLUSTER"),
                            'encrypted' => true
                        );
                        $pusher = new Pusher(
                            env('PUSHER_APP_KEY'),
                            env('PUSHER_APP_SECRET'),
                            env('PUSHER_APP_ID'),
                            $options
                        );
                        $pusher->trigger('pedidos-pendientes', 'App\Events\EventoPedidos', $dataEvento);
                   } catch (\Exception $th) {
                       Log::error($th);
                   }
                    
                    // $d = array();
                    // array_push($d,$dataEvento);
                    // $success = event(new EventoPedidos( $dataEvento));
                    // try {
                    //     $d = array();
                    //     array_push($d,$dataEvento);
                    //     $d= $dataEvento;
                    //     // event(new \App\Events\EventoPedidos($d));
                    //     Event::dispatch(new EventoPedidos($dataEvento));
                    // } catch (\Exception $th) {
                    //     //throw $th;
                    //     Log::error($th);
                    // }
                }
            }
        }
 

        // end generar evento de pedido

        if ($ticket == true) {
            $empresa = array(
                "nombre" => "EMPTATODO EMPANADA",
            );
            $venta = Ventas::where("id", $venta_id)->first();
            $detalles =  VentaDetalleArticulo::where("venta_id", $venta_id)->where("eliminado",false)->get();
            $pagos = VentaDetallePago::select("ventas_detalle_pago.monto", "tipopago.tipo_pago")
                ->leftjoin("tipopago", "tipopago.id", "=", "ventas_detalle_pago.tipopago_id")
                ->where("tipopago.eliminado", false)
                ->where("ventas_detalle_pago.eliminado", false)
                ->where("venta_id", $venta_id)
                ->get();
            // $logo = Empresa::select("thumbnail")->first();
            // $path = public_path("images/thumbnail/").$logo->thumbnail;
            $path = public_path("images/logo.jpg");
            if (file_exists($path)) {
                $logo = "images/logo.jpg";
            }
            $path_file = $this->ticket($venta, $detalles, $pagos, $empresa, $logo);
            $path = "fpdf/fpdf_ticket.pdf";
            $path =   public_path($path);
            $pdf = file_get_contents($path);
            $data = base64_encode($pdf);

            return response()->json(["status" => "success",   "message" => "Guardado!", "data" => $data]);
        }

        if ($venta) {
            return response()->json(["status" => "success",  "message" => "Guardado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VentasController  $ventasController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $venta_id = $id;
        // $creator_id = auth()->user()->creator_id;
        if (!$request->ajax()) return redirect()->route("home");

        $venta = Ventas::select("fecha", "monto", "created_at")->where("id", $venta_id)->where("eliminado", false)->first();

        $t1_hora_desde = "07:30";
        $t1_hora_hasta = "16:00";

        $t2_hora_desde = "16:01";
        $t2_hora_hasta = "23:59";

        if ($venta) {
            $venta_detalle = VentaDetalleArticulo::select("cantidad", "articulo_id")->where("venta_id", $venta_id)->where("eliminado",false)->get();
            if ($venta_detalle) {
                foreach ($venta_detalle as $vd) {
                    $cant_art = (int)$vd["cantidad"];
                    Articulo::where("id", $vd["articulo_id"])->increment("stock", $vd["cantidad"]);
                    // BEGIN ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 
                    $dia = date("d");
                    $mes = date("m");
                    $anio = date("Y");
                    if(date("H:i") >= $t1_hora_desde && date("H:i")<= $t1_hora_hasta ){
                        ArticuloPorDia::firstOrCreate(["articulo_id"=> $vd["articulo_id"],"dia"=>$dia,"mes" => $mes, "anio" => $anio, "t1" => true]);
                        ArticuloPorDia::where("dia",$dia)->where("mes",$mes )->where("anio",  $anio)->where("t1",true)->where("articulo_id",$vd["articulo_id"])->where("cantidad",'>',0)->decrement("cantidad", $cant_art);
                    }

                    if(date("H:i") >= $t2_hora_desde && date("H:i")<= $t2_hora_hasta ){
                        ArticuloPorDia::firstOrCreate(["articulo_id"=> $vd["articulo_id"],"dia"=>$dia,"mes" => $mes, "anio" => $anio, "t2" => true]);
                        ArticuloPorDia::where("dia",$dia)->where("mes",$mes )->where("anio",  $anio)->where("t2",true)->where("articulo_id",$vd["articulo_id"])->where("cantidad",">",0)->decrement("cantidad", $cant_art);
                    }
                    // END ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 
                }
                VentaDetalleArticulo::where("venta_id", $venta_id)->update(["eliminado" => true]);
            }
            $mes_fecha = date("m", strtotime($venta['fecha']));
            $anio_fecha = date("Y", strtotime($venta['fecha']));
            $monto = $venta['monto'];

            if ($monto !== null) {
                Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_ventas", $monto);
                Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("cantidad_ventas", 1);
            }


            $d = Ventas::where("id", $venta_id)->where("eliminado", false)->update(["eliminado" => true]);

            if($venta["fecha"] == date("Y-m-d") ){
                if($d){
                    $data = array();
                    $data["metodo"] = "destroy";
                    $data["estado"] = "eliminar";
                    $data["venta_id"] =  $venta_id;
                    $data["created_at"] =  date("Y-m-d H:i",strtotime($venta['created_at']));
                    
                    try {
                        // generar evento de pedido
                        $options = array(
                            'cluster' => env("PUSHER_APP_CLUSTER"),
                            'encrypted' => true
                        );
                        $pusher = new Pusher(
                            env('PUSHER_APP_KEY'),
                            env('PUSHER_APP_SECRET'),
                            env('PUSHER_APP_ID'),
                            $options
                        );
                        $pusher->trigger('pedidos-pendientes', 'App\Events\EventoPedidos', $data );
                    } catch (\Exception $th) {
                        Log::error($th);
                    }
                    // end generar evento de pedido
                    // try {
                    //     event(new EventoPedidos( $data));
                    // } catch (\Exception $th) {
                    //     //throw $th;
                    //     Log::error($th);
                    // }
                }
            }

            return response()->json(["status" => "success", "message" => "Eliminado"]);
        }

        return response()->json(["status" => "error", "message" => "Error "]);
    }















    public function ticket($venta, $detalles, $pagos, $empresa = null, $logo = null)
    {
        define('EURO', ''); // Constante con el símbolo Euro.
        $pdf = new FPDF('P', 'mm', array(80, 170)); // Tamaño tickt 80mm x 150 mm (largo aprox)
        $pdf->AddPage();
        if ($logo !== null) {
            $image = public_path($logo);
            $pdf->Image($image, 27, 1, 25); // 27x ,1y, 25 tamaño imagen
            $pdf->ln(20);
        }

        // 'nombre','cuit','email','telefono','whatsapp','provincia' ,'direccion',"path_thumbnail"

        // $empresa["nombre"] = "Emptanadas";

        // CABECERA
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(60, 4, trim($empresa["nombre"] ? $empresa["nombre"] : ''), 0, 1, 'C');
        $pdf->SetFont('Helvetica', '', 8);
        // $pdf->Cell(60, 4, 'C.I.F.: 01234567A', 0, 1, 'C');
        // $pdf->Cell(60, 4, 'C/ Arturo Soria, 1', 0, 1, 'C');
        // if ($empresa->direccion) $pdf->Cell(60, 4, $empresa->direccion ? $empresa->direccion : '', 0, 1, 'C');
        // if ($empresa->telefono)  $pdf->Cell(60, 4, $empresa->telefono ? $empresa->telefono : '', 0, 1, 'C');
        // if ($empresa->whatsapp) $pdf->Cell(60, 4, $empresa->whatsapp ? $empresa->whatsapp : '', 0, 1, 'C');
        // if ($empresa->email)  $pdf->Cell(60, 4, $empresa->email ? $empresa->email : '', 0, 1, 'C');

        // DATOS FACTURA        
        // $pdf->Ln(5);
        // $pdf->Cell(60, 4, 'Factura Simpl.: F2019-000001', 0, 1, '');
        $pdf->Cell(60, 4, $venta["fecha"] . " " . $venta["hora"], 0, 1, 'C');

        $cliente = isset($venta["cliente"]) && !empty($venta["cliente"]) ? $venta["cliente"] : "Consumidor Final";
        $pdf->Cell(60, 4, 'Cliente: ' . $cliente, 0, 1, 'C');


        // COLUMNAS
        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->Cell(30, 10, 'Articulo', 0);
        // $pdf->Cell(5, 10, 'Cant', 0, 0, 'R');
        $pdf->Cell(10, 10, 'Precio', 0, 0, 'R');
        $pdf->Cell(15, 10, 'Total', 0, 0, 'R');
        $pdf->Ln(8);
        $pdf->Cell(60, 0, '', 'T');
        $pdf->Ln(1);

        // PRODUCTOS
        $pdf->SetFont('Helvetica', '', 7);
        foreach ($detalles as $item) {
            $pdf->MultiCell(30, 4,  $item["articulo"] . " x" . (int)$item["cantidad"], 0, 'L');
            $pdf->Cell(35, -5, '', 0, 0, 'R');
            $pdf->Cell(10, -5, $item["precio"] . EURO, 0, 0, 'R');
            $pdf->Cell(15, -5, $item["subtotal"] . EURO, 0, 0, 'R');
            $pdf->Ln(1);
        }

        // $pdf->MultiCell(30, 4, 'Malla naranjas 3Kg', 0, 'L');
        // $pdf->Cell(35, -5, '1', 0, 0, 'R');
        // $pdf->Cell(10, -5, number_format(round(1.25, 2), 2, ',', ' ') . EURO, 0, 0, 'R');
        // $pdf->Cell(15, -5, number_format(round(1.25, 2), 2, ',', ' ') . EURO, 0, 0, 'R');
        // $pdf->Ln(3);
        // $pdf->MultiCell(30, 4, 'Uvas', 0, 'L');
        // $pdf->Cell(35, -5, '5', 0, 0, 'R');
        // $pdf->Cell(10, -5, number_format(round(1, 2), 2, ',', ' ') . EURO, 0, 0, 'R');
        // $pdf->Cell(15, -5, number_format(round(1 * 5, 2), 2, ',', ' ') . EURO, 0, 0, 'R');
        // $pdf->Ln(3);

        //SUMATORIO DE LOS PRODUCTOS Y EL IVA 
        $pdf->Ln(1);
        $pdf->Cell(60, 0, '', 'B');
        $pdf->Ln(1);
        $pdf->Cell(25, 10, 'TOTAL: ', 0);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, $venta["monto"] . EURO, 0, 0, 'R');
        $pdf->Ln(3);
        // $pdf->Cell(25, 10, 'DESCUENTO %', 0);
        // $pdf->Cell(20, 10, '', 0);
        // $pdf->Cell(15, 10, $venta["descuento_porcentaje"] . EURO, 0, 0, 'R');
        // $pdf->Ln(3);
        $pdf->Cell(25, 10, 'DESCUENTO:', 0);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, $venta["descuento_importe"] . EURO, 0, 0, 'R');
        $pdf->Ln(3);
        // $pdf->Cell(25, 10, 'TOTAL SIN I.V.A.', 0);
        // $pdf->Cell(20, 10, '', 0);
        // $pdf->Cell(15, 10, $venta["monto"] . EURO, 0, 0, 'R');
        // $pdf->Ln(3);
        // $pdf->Cell(25, 10, 'I.V.A. 21%', 0);
        // $pdf->Cell(20, 10, '', 0);
        // $pdf->Cell(15, 10, number_format(round((round(12.25, 2)), 2) - round((round(2 * 3, 2) / 1.21), 2), 2, ',', ' ') . EURO, 0, 0, 'R');
        // $pdf->Ln(3);
        $pdf->Cell(25, 10, 'TOTAL A PAGAR:', 0);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, ($venta["monto"] - $venta["descuento_importe"]) . EURO, 0, 0, 'R');

        $pdf->Ln(7);
        // $pdf->Cell(60, 0, '','T');
        // $pdf->Ln();

        // ESTADO PAGO
        if ($venta["pago_completo"] == false) {
            $pdf->Cell(25, 10, 'ESTADO PAGO: ', 0);
            $pdf->Cell(20, 10, '', 0);
            $pdf->Cell(15, 10, "Pendiente", 0, 0, 'R');
            $pdf->Ln(1);
        } else {
            $pdf->Cell(25, 10, 'ESTADO PAGO: ', 0);
            $pdf->Cell(20, 10, '', 0);
            $pdf->Cell(15, 10, "Completo", 0, 0, 'R');
            $pdf->Ln(1);
        }

        // PAGOS
        // $pdf->Ln(1);
        // $pdf->Cell(60, 0, '', 'B');
        // $pdf->Ln(1);

        // $pdf->Cell(25, 10, 'PAGOS: ', 0);
        $pdf->Ln(7);


        // PAGOS
        if (isset($pagos) && !empty($pagos)) {
            foreach ($pagos as $pago) {
                if ((int)$pago["monto"] !== 0) $pdf->Cell(60, 4, 'Pagos en ' . $pago['tipo_pago'] . ' : ' . (int)$pago["monto"], 0, 1, '');
                $pdf->Ln(0);
            }
        }
        $pdf->Ln();
        // PIE DE PAGINA $pdf->Ln(10); 
        // if (isset(auth()->user()->nombre)) {
        //     $pdf->Cell(60, 0, 'Atendido por: ' . auth()->user()->nombre, 0, 1, 'C');
        //     $pdf->Ln(3);
        // }
        // $pdf->Cell(60, 0, 'CADUCA EL DIA 01/11/2019', 0, 1, 'C');
        $pdf->Cell(60, 0, '!!! GRACIAS POR SU COMPRA !!!', 0, 1, 'C');
        $path = "fpdf/fpdf_ticket.pdf";
        $path =   public_path($path);
        $pdf->Output($path, "f");
        return $path;
    }


    public function comprobante(Request $request, $id)
    {


        // $pdf = PDF::loadView('ventas.factura1' )->setPaper("a4", 'portrait')->stream();
        // return $pdf;  

        //  $data = [
        //     'titulo' => 'Styde.net'
        // ];
        // $pdf = PDF::loadView('ventas.ticket', $data)  //->output();
        // ->setPaper('b7', 'portrait')->stream();
        // return response()->json(["id"=>$id,"r"=>$request->all()]);


        // $validator = \Validator::make($request->all(), [
        //     'factura' => 'required|string',
        //     'ticket' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()->all()]);
        // }

        $venta_id = $id;
        $factura = (isset(request()->factura) && request()->factura == "true") ? true : null;
        $ticket = (isset(request()->ticket) && request()->ticket == "true") ? true : null;
        if ($factura == true && $ticket == true) {
            $factura = true;
            $ticket = false;
        }
        $venta = Ventas::select('ventas.id', 'ventas.fecha', 'ventas.hora', 'ventas.monto', \DB::raw("(ventas.monto-ventas.descuento_importe) as subtotal"), 'cliente_id', "cliente.nombre", 'ventas.descuento_porcentaje', "ventas.descuento_importe", "ventas.comentario", "ventas.pago_completo")
            ->leftjoin("cliente", "cliente.id", "=", "ventas.cliente_id")
            ->where('ventas.eliminado', false)
            ->where("ventas.id", $venta_id)
            ->first();

        if (!$venta) {
            return response()->json(["status" => "error", "message" => "Venta no existe!"]);
        }
        $detalles = VentaDetalleArticulo::select("cantidad", "subtotal", "descuento", "articulo", "precio", "articulo_id")->where("venta_id", $venta_id)->get();
        $pagos = VentaDetallePago::select("monto")->where("venta_id", $venta_id)->first();
        // $pagos = (int)$pagos["efectivo"];
        // return response()->json($pagos);
        if ($factura == true) {
        };
        // $pdf = PDF::loadView('ventas.factura1', compact("venta", "detalles", "pagos"))->setPaper("a4", 'portrait')->stream();
        // if($ticket==true) {
        //     $pdf = PDF::loadView('ventas.ticket',compact("venta","detalles","pagos"))->setPaper("b7", 'portrait')->stream();
        // } 

        // $path = public_path('pdf');
        // $fileName =   'comprobante.pdf' ;
        // $pdf->save($path . '/' . $fileName);
        // $pdf = public_path('pdf/'.$fileName);
        // $pdf = PDF::loadView('ventas.factura1', compact("venta", "detalles", "pagos"))->setPaper("a4", 'portrait')->stream();

        $logo  = null;
        $th = Empresa::select('nombre', 'cuit', 'email', 'telefono', 'whatsapp', 'provincia', 'direccion', "path_thumbnail")->first();
        $path = public_path($th->path_thumbnail);
        if (file_exists($path)) {
            $logo = $th->path_thumbnail;
        }
        return response()->download($this->ticket($venta, $detalles, $pagos, $th, $logo));


        // return $pdf; //response()->download($pdf);


    }












































































    public function factura()
    {
        /// Powered by Evilnapsis go to http://evilnapsis.com

        $pdf = new FPDF($orientation = 'P', $unit = 'mm');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 20);
        $textypos = 5;
        $pdf->setY(12);
        $pdf->setX(10);
        // Agregamos los datos de la empresa
        $pdf->Cell(5, $textypos, "NOMBRE DE LA EMPRESA");
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(30);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "DE:");
        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(35);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "Nombre de la empresa");
        $pdf->setY(40);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "Direccion de la empresa");
        $pdf->setY(45);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "Telefono de la empresa");
        $pdf->setY(50);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "Email de la empresa");

        // Agregamos los datos del cliente
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(30);
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "PARA:");
        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(35);
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "Nombre del cliente");
        $pdf->setY(40);
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "Direccion del cliente");
        $pdf->setY(45);
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "Telefono del cliente");
        $pdf->setY(50);
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "Email del cliente");

        // Agregamos los datos del cliente
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->setY(30);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, "FACTURA #12345");
        $pdf->SetFont('Arial', '', 10);
        $pdf->setY(35);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, "Fecha: 11/DIC/2019");
        $pdf->setY(40);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, "Vencimiento: 11/ENE/2020");
        $pdf->setY(45);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, "");
        $pdf->setY(50);
        $pdf->setX(135);
        $pdf->Cell(5, $textypos, "");

        /// Apartir de aqui empezamos con la tabla de productos
        $pdf->setY(60);
        $pdf->setX(135);
        $pdf->Ln();
        /////////////////////////////
        //// Array de Cabecera
        $header = array("Cod.", "Descripcion", "Cant.", "Precio", "Total");
        //// Arrar de Productos
        $products = array(
            array("0010", "Producto 1", 2, 120, 0),
            array("0024", "Producto 2", 5, 80, 0),
            array("0001", "Producto 3", 1, 40, 0),
            array("0001", "Producto 3", 5, 80, 0),
            array("0001", "Producto 3", 4, 30, 0),
            array("0001", "Producto 3", 7, 80, 0),
        );
        // Column widths
        $w = array(20, 95, 20, 25, 25);
        // Header
        for ($i = 0; $i < count($header); $i++)
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        $pdf->Ln();
        // Data
        $total = 0;
        foreach ($products as $row) {
            $pdf->Cell($w[0], 6, $row[0], 1);
            $pdf->Cell($w[1], 6, $row[1], 1);
            $pdf->Cell($w[2], 6, number_format($row[2]), '1', 0, 'R');
            $pdf->Cell($w[3], 6, "$ " . number_format($row[3], 2, ".", ","), '1', 0, 'R');
            $pdf->Cell($w[4], 6, "$ " . number_format($row[3] * $row[2], 2, ".", ","), '1', 0, 'R');

            $pdf->Ln();
            $total += $row[3] * $row[2];
        }
        /////////////////////////////
        //// Apartir de aqui esta la tabla con los subtotales y totales
        $yposdinamic = 60 + (count($products) * 10);

        $pdf->setY($yposdinamic);
        $pdf->setX(235);
        $pdf->Ln();
        /////////////////////////////
        $header = array("", "");
        $data2 = array(
            array("Subtotal", $total),
            array("Descuento", 0),
            array("Impuesto", 0),
            array("Total", $total),
        );
        // Column widths
        $w2 = array(40, 40);
        // Header

        $pdf->Ln();
        // Data
        foreach ($data2 as $row) {
            $pdf->setX(115);
            $pdf->Cell($w2[0], 6, $row[0], 1);
            $pdf->Cell($w2[1], 6, "$ " . number_format($row[1], 2, ".", ","), '1', 0, 'R');

            $pdf->Ln();
        }
        /////////////////////////////

        $yposdinamic += (count($data2) * 10);
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->setY($yposdinamic);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "TERMINOS Y CONDICIONES");
        $pdf->SetFont('Arial', '', 10);

        $pdf->setY($yposdinamic + 10);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "El cliente se compromete a pagar la factura.");
        $pdf->setY($yposdinamic + 20);
        $pdf->setX(10);
        $pdf->Cell(5, $textypos, "Powered by Evilnapsis");


        $path = "fpdf/fpdf_factura.pdf";
        $path =   public_path($path);
        $pdf->Output($path, 'f');
        return $path;
    }
}
