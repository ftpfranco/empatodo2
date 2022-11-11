<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\TipoPago;
use App\ClienteCC;
use App\Proveedor;
use App\CCorriente;
use App\ProveedorCC;
use App\ClienteCCPago;
use App\ProveedorCCPago;
use Illuminate\Http\Request;

class ProveedorCCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $info =  ProveedorCC::select(\DB::raw("sum(proveedor_cc.monto) as total, count(proveedor_cc.id) as total_cantidad"))
            ->leftjoin("proveedor", "proveedor.id", "=", "proveedor_cc.proveedor_id")
            ->where('proveedor_cc.eliminado', false)
            ->first();

        // 'id','cliente_id','monto',, 'eliminado','user_id','creator_id','created_at','updated_at'
        $ccorrientes = ProveedorCC::select('proveedor_cc.id', 'proveedor_cc.monto', "proveedor.nombre")
            ->leftjoin("proveedor", "proveedor.id", "=", "proveedor_cc.proveedor_id")
            ->where('proveedor_cc.eliminado', false)
            ->orderby("proveedor_cc.id", "desc")
            ->paginate(15);

        $tipopagos =  TipoPago::select("id", "tipo_pago")->pluck("tipo_pago", "id");

        return view("proveedores.ccorriente", compact("ccorrientes", "info", "tipopagos"));
    }




    public function filtro(Request $request)
    {


        $ccorrientes = ProveedorCC::select('proveedor_cc.id', 'proveedor_cc.monto', "proveedor.nombre")
            ->leftjoin("proveedor", "proveedor.id", "=", "proveedor_cc.proveedor_id")
            ->where('proveedor_cc.eliminado', false)
            ->orderby("proveedor_cc.id", "desc")
            ->paginate(15);

        return response()->json(view("proveedores.ccorriente_data", compact("ccorrientes"))->render());
    }



    public function detalle(Request $request, $id)
    {
        $pagos = ProveedorCCPago::select("id", "fecha", "monto", "monto_anterior")->where("proveedor_id", $id)->orderby("id", "desc")->paginate(10);
        if ($request->ajax()) {
            return response()->json(view("proveedores.ccdetalles_data", compact("pagos"))->render());
        }
        
        $info =  ProveedorCC::select(\DB::raw("sum(proveedor_cc.monto) as total"))
            ->leftjoin("proveedor", "proveedor.id", "=", "proveedor_cc.proveedor_id")
            ->where("proveedor_cc.proveedor_id", $id)
            ->where('proveedor_cc.eliminado', false)
            ->first();


        $proveedor = Proveedor::select("id", "nombre", "telefono", "email", "direccion")->where("id", $id)->where("eliminado", false)->first();
        $tipopagos =  TipoPago::select("id", "tipo_pago")->pluck("tipo_pago", "id");

        return view("proveedores.ccdetalles", compact("proveedor", "pagos", "tipopagos", "info"));
    }



    public function ingresarpago(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'fecha' => 'required|date',
            'tipopago' => 'required|numeric',
            'monto' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $proveedor = Proveedor::where("id", $id)->first();
        if (!$proveedor) {
            return response()->json(["status" => "error", "message" => "Error al guardar!"]);
        }


        $tipopago =  request()->tipopago;
        $monto = request()->monto;
        $fecha = request()->fecha;

        if ($tipopago) {
            $ti = TipoPago::where("id", $tipopago)->first();
            if (!$ti) {
                return response()->json(["status" => "error", "message" => "Tipo pago no existe!"]);
            }
        }
        $montoP = ProveedorCC::select("monto")->where("proveedor_id", $id)->first();
        $saldo_anterior = $montoP->monto;

        // 'id','cliente_id','tipopago_id',"fecha",'monto', 'eliminado','user_id','creator_id','created_at','updated_at'
        $cc = ProveedorCCPago::create([
            "fecha" => $fecha,
            "monto" => $monto,
            "monto_anterior" => $montoP->monto,
            "tipopago_id" => $tipopago,
            "proveedor_id" => $id
        ]);
        if (!$cc)  return response()->json(["status" => "error", "message" => "Error , no se pudo guardar!"]);


        $increment = ProveedorCC::where("proveedor_id", $id)->decrement("monto", $monto);

        $data = ProveedorCC::select("proveedor_id", "monto")->where("proveedor_id", $id)->first();
        $data["importe"] =  $monto;
        $data["saldo_anterior"] =  $saldo_anterior;
        $data["fecha"] = $fecha;

        return response()->json(["status" => "success", "message" => "Pago ingresado correctamente!", "data" => $data]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //'id','monto','fecha','comentario','cliente_id','creator_id', 'eliminado','created_at','updated_at'

        $creator_id = auth()->user()->creator_id;
        $art = $request->validate([
            'fecha' => 'date',
            'cliente_id' => 'numeric',
            'monto' => 'required|numeric',
            'comentario' => 'string|max:500'
        ]);

        $fecha = request()->fecha ? request()->fecha : date("Y-m-d");
        $cliente_id = request()->cliente_id ? request()->cliente_id : null;

        $item =  CCorriente::create([
            "fecha" => $fecha,
            "cliente_id" => $cliente_id,
            "creator_id" => $creator_id
        ]);
        if ($item) {
            return response()->json(["status" => "success", "message" => "Creado correctamente!"]);
        }
        return response()->json(["status" => "error", "message" => "Error al guardar!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CCorrienteController  $cCorrienteController
     * @return \Illuminate\Http\Response
     */
    public function show($ccorriente)
    {
        //
        $creator_id = auth()->user()->creator_id;
        $item = CCorriente::select('id', 'monto', 'fecha', 'cliente_id',  'created_at', 'updated_at')
            ->where('id', $ccorriente)
            ->where('eliminado', false)
            ->where('creator_id', $creator_id)
            ->first();

        if (!empty($item)) {
            $data = array();
            $data['id'] = $item['id'];
            $data['fecha'] = $item['fecha'];
            $data['monto'] = $item['monto'];
            $data['created_at'] = $item['created_at'];
            $data['updated_at'] = $item['updated_at'];
            if ($item['cliente_id']) {
                $data['cliente'] = Cliente::select('id', 'cliente')->where('id', $item['cliente_id'])->where('creator_id', $creator_id)->first();
            }
            $item = $data;
        }

        return response()->json(["status" => "success", "cuenta_corriente" => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CCorrienteController  $cCorrienteController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $ccorriente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CCorrienteController  $cCorrienteController
     * @return \Illuminate\Http\Response
     */
    public function destroy($ccorriente)
    {
        //
    }
}
