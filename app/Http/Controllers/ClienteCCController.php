<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\CCorriente;
use App\ClienteCC;
use App\ClienteCCPago;
use App\TipoPago;
use Illuminate\Http\Request;

class ClienteCCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $info =  ClienteCC::select(\DB::raw("sum(cliente_cc.monto) as total, count(cliente_cc.id) as total_cantidad"))
            ->leftjoin("cliente", "cliente.id", "=", "cliente_cc.cliente_id")
            ->where('cliente_cc.eliminado', false)
            ->first();


        // 'id','cliente_id','monto',, 'eliminado','user_id','creator_id','created_at','updated_at'
        $ccorrientes = ClienteCC::select('cliente_cc.cliente_id', 'cliente_cc.monto', "cliente.nombre")
            ->leftjoin("cliente", "cliente.id", "=", "cliente_cc.cliente_id")
            ->where('cliente_cc.eliminado', false)
            ->orderby("cliente_cc.id","desc")
            ->paginate(15);


        $tipopagos =  TipoPago::select("id", "tipo_pago")->pluck("tipo_pago", "id");


        return view("clientes.ccorriente", compact("ccorrientes", "info", "tipopagos"));
    }




    public function filtro(Request $request)
    {

        $ccorrientes = ClienteCC::select('cliente_cc.cliente_id', 'cliente_cc.monto', "cliente.nombre")
            ->leftjoin("cliente", "cliente.id", "=", "cliente_cc.cliente_id")
            ->where('cliente_cc.eliminado', false)
            ->orderby("cliente_cc.id","desc")
            ->paginate(15);

        return response()->json(view("clientes.ccorriente_data", compact("ccorrientes"))->render());
    }




    public function detalle($id)
    {

        $cliente = Cliente::select("id", "nombre", "telefono", "email", "direccion")->where("id", $id)->first();
        $tipopagos =  TipoPago::select("id", "tipo_pago")->pluck("tipo_pago", "id");
        
        $info =  ClienteCC::select(\DB::raw("sum(cliente_cc.monto) as total"))
        ->leftjoin("cliente", "cliente.id", "=", "cliente_cc.cliente_id")
        ->where("cliente_cc.cliente_id",$id)
        ->where('cliente_cc.eliminado', false)
        ->first();
        
        $pagos = ClienteCCPago::select("id", "fecha", "monto","monto_anterior")->where("cliente_id", $id)->orderby("id", "desc")->paginate(10);
        return view("clientes.ccdetalles", compact("cliente", "pagos", "tipopagos", "info"));
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

        $cliente = Cliente::where("id", $id)->first();
        if (!$cliente) {
            return response()->json(["status" => "error", "message" => "Error al ingresar pago!"]);
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

        $montoP = ClienteCC::select("monto")->where("cliente_id", $id)->first();
        $saldo_anterior = $montoP->monto;

        // 'id','cliente_id','tipopago_id',"fecha",'monto', 'eliminado','user_id','creator_id','created_at','updated_at'
        $cc = ClienteCCPago::create([
            "fecha" =>  $fecha,
            "monto" => $monto,
            "monto_anterior"=> $saldo_anterior,
            "tipopago_id" =>  $tipopago,
            "cliente_id" => $id
        ]);

        if (!$cc)  return response()->json(["status" => "error", "message" => "Error al ingresar pago!"]);

        $increment = ClienteCC::where("cliente_id", $id)->decrement("monto", $monto);
        $data = ClienteCC::select("cliente_id", "monto")->where("cliente_id",$id)->first();
        $data["importe"] =  $monto;
        $data["fecha"] =  $fecha;
        $data["saldo_anterior"] =  $saldo_anterior;


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
            return response()->json(["status" => "success", "message" => "Cuenta corriente creado correctamente!"]);
        }
        return response()->json(["status" => "error", "message" => "Error al crear Cuenta corriente!"]);
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
}
