<?php

namespace App\Http\Controllers;

use App\User;
use App\Ventas;
use App\Cliente;
use App\Reportes;
use Illuminate\Http\Request;

class ReportesController extends Controller
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
    public function index(Request $request)
    {
        //

        $compras = Reportes::select('monto_compras', "mes")->where('eliminado', false)->where("anio", date("Y"))->pluck("monto_compras", "mes");
        $ventas = Reportes::select('monto_ventas', "mes")->where('eliminado', false)->where("anio", date("Y"))->pluck("monto_ventas", "mes");
        $ingresos = Reportes::select('monto_ingresos', "mes")->where('eliminado', false)->where("anio", date("Y"))->pluck("monto_ingresos", "mes");
        $egresos = Reportes::select('monto_egresos', "mes")->where('eliminado', false)->where("anio", date("Y"))->pluck("monto_egresos", "mes");



        if ($request->ajax()) {
            return response()->json(["status" => "success", "data" => ["compras" => $compras, "ventas" => $ventas, "ingresos" => $ingresos, "egresos" => $egresos]]);
        }
        return view("reportes.index", compact("compras", "ventas", "ingresos", "egresos"));
        // return response()->json(["status" => "success", "marca" => $marca]);
    }




    public function ventas(Request $request)
    {

        $clientes =  Cliente::select("id", "nombre")->where("eliminado", false)->where("id", "<>", "1")->pluck("nombre", "id");

        $users_id = Ventas::select('user_id')->groupby("user_id")->where("eliminado", false)->get();

        // empleados que realizaron ventas
        $empleados = null;
        if ($users_id) {
            $empleados =  User::select("id", "nombre")->where("eliminado", false)->where("es_empleado", true)->wherein("id", $users_id)->pluck("nombre", "id");
        }

        $ventas = Ventas::select('ventas.id', "ventas_estadoenvio.nombre as estadoenvio", 'ventas.fecha',   'ventas.monto',  'cliente.nombre', 'ventas.pago_completo')
            ->leftjoin("cliente", "cliente.id", '=', 'ventas.cliente_id')
            ->leftjoin("ventas_estadoenvio", "ventas_estadoenvio.id", "=", "ventas.tipoenvio_id")
            ->where('ventas.eliminado', false)
            // ->where("ventas.fecha", date("Y-m-d"))
            // ->orderby("ventas.id", 'desc')
            ->orderby("ventas.fecha", 'desc')
            ->paginate(15);

        return view("reportes.ventas", compact("ventas", "clientes", "cantidad_completas", "cantidad_porcobrar", "monto_completas", "monto_porcobrar", "empleados"));
    }




    public function filtro(Request $request)
    {

        if (!$request->ajax()) return redirect()->route("reportes");

        $validator = \Validator::make($request->all(), [
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date',
            'cliente' => 'nullable|numeric',
            'empleado' => 'nullable|numeric',
            'estadopago' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $fecha_desde = request()->fecha_desde ? request()->fecha_desde : null;
        $fecha_hasta = request()->fecha_hasta ? request()->fecha_hasta : null;
        $cliente = (request()->cliente != 0) ? request()->cliente : null;
        $empleado = request()->empleado ? request()->empleado : null;
        $estadopago = request()->estadopago<0 ? null:  request()->estadopago;

        if (request()->estadopago == 0) $estadopago = null;
        if (request()->estadopago == 1) $estadopago = true; // pago completo
        if (request()->estadopago == 2) $estadopago = false; // pago incompleto

        $ventas = Ventas::select('ventas.id', "ventas_estadoenvio.nombre as estadoenvio", 'ventas.fecha',  'ventas.monto',  'cliente.nombre', 'ventas.pago_completo')
            ->leftjoin("cliente", "cliente.id", '=', 'ventas.cliente_id')
            ->leftjoin("ventas_estadoenvio", "ventas_estadoenvio.id", "=", "ventas.tipoenvio_id")
            // ->where("ventas.fecha",date("Y-m-d"))
            ->where('ventas.eliminado', false);
 

        if ($fecha_desde !== null && $fecha_hasta !== null) {
            $ventas = $ventas->whereBetween("ventas.fecha", [$fecha_desde, $fecha_hasta]);
        }
        if ($fecha_desde !== null && $fecha_hasta == null) {
            $ventas = $ventas->whereBetween("ventas.fecha", [$fecha_desde, $fecha_desde]);
        }
        if ($fecha_desde == null && $fecha_hasta !== null) {
            $ventas = $ventas->whereBetween("ventas.fecha", [$fecha_hasta, $fecha_hasta]);
        }
        if ($cliente !== null) {
            $ventas = $ventas->where("ventas.cliente_id", $cliente);
        }
        if ($estadopago !== null) {
            $ventas = $ventas->where("ventas.pago_completo", $estadopago);
        }
        if ($empleado) {
            // verificar rol empleado del user_id 
            $ventas = $ventas->where("ventas.user_id", $empleado);
        }
        $ventas = $ventas->orderBy("ventas.updated_at", 'desc');
        $ventas = $ventas->paginate(15);

        return response()->json(view("reportes.ventas_data", compact("ventas"))->render());
    }
}// end class
