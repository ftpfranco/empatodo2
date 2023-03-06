<?php

namespace App\Http\Controllers;

use App\Cajas;
use App\CajasDetalle;
use App\CajasDetalleH;
use App\CajasIngreso;
use App\CajasIngresoEgreso;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CajasController extends Controller
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
        //
        $user_id = auth()->user()->id;

        // campo estado, justo, con faltante
        $caja_abierta = CajasDetalle::select('id', 'inicio_fecha', 'inicio_hora', 'monto_inicio', 'monto_estimado', 'ingresos', 'egresos')->where('caja_abierta', true)->get();

       

        if( auth()->user()->es_empleado == true ){
            $historial = CajasDetalle::select('id',  'user_id', 'inicio_fecha', 'inicio_hora', 'cierre_fecha', 'cierre_hora', 'monto_inicio', 'monto_estimado', 'monto_real', 'diferencia', 'ingresos',  'egresos')
                ->where("caja_abierta", false)
                ->where("user_id",$user_id)
                ->orderby("id", "desc")
                //->paginate(15);
                ->take(5)->get();
            return view('cajas.index', compact('caja_abierta', 'historial'));

        }

        // $historial = CajasDetalle::select('id',  'user_id', 'inicio_fecha', 'inicio_hora', 'cierre_fecha', 'cierre_hora', 'monto_inicio', 'monto_estimado', 'monto_real', 'diferencia', 'ingresos',  'egresos')
        //     ->where("caja_abierta", false)
        //     ->orderby("id", "desc")
        //     //->paginate(15);
        //     ->take(10)->get();
            // 'id','cajadetalle_id','inicio_fecha','cierre_fecha','inicio_hora','cierre_hora','monto_inicio','monto_estimado','monto_real','diferencia',
            // 'estado', 
            // 'eliminado','created_at','updated_at'
        $historial = CajasDetalleH::select('id','cajadetalle_id','inicio_fecha','cierre_fecha','inicio_hora','cierre_hora','monto_inicio','monto_estimado','monto_real','diferencia','estado'  )
        ->where("eliminado",false)
        ->orderby("id","desc")->take(10)->get();
          
        return view('cajas.index', compact('caja_abierta', 'historial'));
        // return response()->json(["status"=>"success","cajas"=>$cajas]);
    }

    // public function filtro(Request $request)
    // {

    //     $validator = \Validator::make($request->all(), [
    //         'desde' => 'nullable|date',
    //         'hasta' => 'nullable|date',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()->all()]);
    //     }


    //     $desde = request()->desde ? request()->desde : null;
    //     $hasta = request()->hasta ? request()->hasta : null;

    //     $historial = CajasDetalle::select('id',  'user_id', 'inicio_fecha', 'inicio_hora', 'cierre_fecha', 'cierre_hora', 'monto_inicio', 'monto_estimado', 'monto_real', 'diferencia', 'ingresos',  'egresos')
    //         ->orderby("inicio_fecha", "desc")
    //         ->where("caja_abierta", false);


    //     if ($desde !== null && $hasta !== null) {
    //         $historial = $historial->whereBetween("inicio_fecha", [$desde, $hasta]);
    //     }
    //     if ($desde !== null && $hasta == null) {
    //         $historial = $historial->whereBetween("inicio_fecha", [$desde, $desde]);
    //     }
    //     if ($desde == null && $hasta !== null) {
    //         $historial = $historial->whereBetween("inicio_fecha", [$hasta, $hasta]);
    //     }


    //     $historial = $historial->paginate(15);

    //     return response()->json(view("cajas.index_data", compact("historial"))->render());
    // }

    public function abrir(Request $request)
    {
        $user_id = auth()->user()->id;
        // $request->validate([
        //     'monto' => 'required|numeric|between:0.00,999999.99',
        //     'fecha' => 'date',
        //     "hora" => ''
        // ]);

        $validator = \Validator::make($request->all(), [
            'monto' => 'required|numeric|max:999999.99',
            'fecha' => 'nullable|date',
            'hora' => 'nullable|date_format:H:i',
        ],[
            'monto.required'=> "El monto ingresado no es valido",
            'monto.numeric'=> "El monto ingresado no es valido",
            "monto.max" => "El monto ingresado no es valido",
            "fecha.date" => "La fecha ingresada no es valido",
            "hora.date_format" => "La hora ingresada  no es valido",
            // "comentario.max" => "El comentario ingresado no es valido"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $fecha =  request()->fecha  ? $request->fecha : date("Y-m-d");
        $hora =  request()->hora  ? $request->hora : date("H:i");
        $monto = request()->monto;

        $abiertas = CajasDetalle::select('id')->where("caja_abierta", true)->get();
        if (count($abiertas)) {
            return response()->json(["status" => "success", "message" => "Ya existe una caja abierta!"]);
        }

        $data = array();
        $data["user_id"] = $user_id;
        $data["caja_id"] = 1;
        $data["inicio_fecha"] = $fecha;
        $data["inicio_hora"] = $hora;
        $data["monto_inicio"] = $monto;
        $data["monto_estimado"] = $monto;
        // $data["ingresos"] = 0;
        // $data["egresos"] = 0;
        $data["caja_abierta"] = true;

        try {
            $caja = CajasDetalle::create($data);
        } catch (\Exception $th) {
            //throw $th;
            return response()->json(["status" => "success",   "message" => "Caja abierta!","data" =>$th]);

        }
        unset($data["user_id"]);
        unset($data["caja_abierta"]);
        
        return response()->json(["status" => "success",   "message" => "Caja abierta!","data" =>$data]);
    }



    public function cerrar(Request $request)
    {
        $user_id = auth()->user()->id;
       
        $validator = \Validator::make($request->all(), [
            'monto_real' => 'required|numeric|between:0.00,999999.99',
            'fecha' => 'nullable|date',
            'hora' => 'nullable|date_format:H:i',
            // 'comentario' => 'nullable|string|max:500'
            'turno_cierre' => 'required|numeric'
        ],[
            'monto_real.required'=> "El monto ingresado no es valido",
            'monto_real.numeric'=> "El monto ingresado no es valido",
            "monto_real.between" => "El monto ingresado no es valido",
            'turno_cierre.required'=> "El Turno de Cierre de caja no es válido",
            'turno_cierre.numeric'=> "El Turno de Cierre de caja no es válido",
            "fecha.date" => "La fecha ingresada no es valido",
            "hora.date_format" => "La hora ingresada  no es valido",
            // "comentario.max" => "El comentario ingresado no es valido"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $turno_cierre = request()->turno_cierre;
        $monto_real = request()->monto_real;
        $fecha = request()->fecha ? request()->fecha : date("Y-m-d");
        $hora = request()->hora ? request()->hora : date("H:i");
        // $comentario = isset(request()->comentario) && !empty(request()->comentario) ? trim(request()->comentario) : null;
        
        $abiertas = CajasDetalle::select('id', \DB::raw('monto_inicio+ingresos-egresos as total'),'inicio_fecha', 'inicio_hora', 'monto_inicio', 'monto_estimado', 'ingresos', 'egresos')->where("caja_abierta", true)->first();
        if (!$abiertas) {
            return response()->json(["status" => "success", "message" => "No existe caja "]);
        }
        $diferencia = $monto_real - $abiertas->total;
        $cajadetalle_id = $abiertas->id;
        $monto_inicio = $abiertas->monto_inicio;
        $monto_estimado = $abiertas->monto_estimado;

        // $estado = ""; ///$diferencia<0?"Faltate": ($diferencia==0)?"Igual":"Sobrante";
        // if ($diferencia == 0) $estado = "Igual";
        // if ($diferencia > 0) $estado = "Sobrante";
        // if ($diferencia < 0) {
        //     $estado = "Faltante";
        //     $diferencia = explode("-", $diferencia)[1];
        // }

        $array = ["user_id"=>$user_id,"cierre_fecha" => $fecha, "cierre_hora" => $hora, "monto_real" => $monto_real, "diferencia" => $diferencia];
        $array["inicio_fecha"] = $abiertas->inicio_fecha;
        $array["inicio_hora"] = $abiertas->inicio_hora;
        $monto_inicio_actualizado = $monto_real; 
        // turno mañana 
        $estado = null;
        if( $turno_cierre == 1){
           $estado = "Turno Mañana";
        }
        // turno tarde 
        if( $turno_cierre == 2){
           $estado = "Turno Tarde";
        }
        // turno noche 
        if( $turno_cierre == 3){
           $estado = "Turno Noche";
        }
        if( in_array( $turno_cierre,array(1,2,3)) ){
            CajasDetalle::where("caja_abierta", true)->update(["monto_inicio"=> $monto_inicio_actualizado,"monto_estimado"=> $monto_inicio_actualizado]);
        }
        // cierre total 
        if( $turno_cierre == 4){
            $estado = "Cierre Total";
            $array["caja_abierta"] = false ;
            CajasDetalle::where("caja_abierta", true)->update($array);
            $array["inicio_fecha"] = $abiertas->inicio_fecha;
            $array["inicio_hora"] = $abiertas->inicio_hora;
            $array["monto_inicio"] = $abiertas->monto_inicio;
            $array["monto_estimado"] = $abiertas->monto_estimado  ;
            $array["ingresos"] = $abiertas->ingresos;
            $array["egresos"] = $abiertas->egresos;
            // unset($array["caja_abierta"]);
            // unset($array["user_id"]);
        }
        // 'id','cajadetalle_id','inicio_fecha','cierre_fecha','inicio_hora','cierre_hora','monto_inicio','monto_estimado','monto_real','diferencia',
        // 'estado', 
        // 'eliminado','created_at','updated_at'
        CajasDetalleH::create([
            "cajadetalle_id" => $cajadetalle_id ,
            'monto_inicio' => $monto_inicio,
            'monto_estimado' => $monto_estimado , 
            "inicio_fecha" => $abiertas->inicio_fecha,
            "inicio_hora" => $abiertas->inicio_hora,
            "cierre_fecha" => $fecha, 
            "cierre_hora" => $hora,
            "monto_real" => $monto_real,
            "estado" => $estado,
            'diferencia' => $diferencia
        ]);


        $array["monto_inicio"] = $monto_inicio;
        $array["estado"] = $estado;
        $array["diferencia"] = $diferencia;
       

        return response()->json(["status" => "success", "message" => "Caja cerrada!","data"=>$array]);
    }



    // public function ingreso(Request $request)
    // {
    //     $user_id = auth()->user()->creator_id;

    //     $validator = \Validator::make($request->all(), [
    //         'importe' => 'required|numeric|between:0.00,999999.99',
    //         'comentario' => 'nullable|string|min:0|max:2000'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()->all()]);
    //     }

    //     $caja_abierta = CajasDetalle::select('id')->where('caja_id', 1)->where('caja_abierta',true)->get();
    //     if (count($caja_abierta) == 0) {
    //         return response()->json(["status" => "success", "message" => "No abrio caja!"]);
    //     }

    //     $array = array();
    //     $id = $caja_abierta[0]->id;
    //     $array["cajadetalle_id"] = $id;
    //     $array["user_id"] = 1;
    //     $array["es_ingreso"] = true;
    //     if (request()->importe)  $array["monto"] = request()->importe;
    //     if (request()->comentario) $array["comentario"] = request()->comentario;

    //     CajasIngresoEgreso::create($array);
    //     $ingresos = CajasIngresoEgreso::select(\DB::raw("sum(monto) as monto"))->where("cajadetalle_id", $id)->where("es_ingreso", true)->get();
    //     CajasDetalle::where("caja_abierta", true)->update(["ingresos" => $ingresos[0]->monto]);
    //     CajasDetalle::where("caja_abierta", true)->increment("monto_estimado" , $ingresos[0]->monto);

    //     $data = CajasDetalle::select('id', 'inicio_fecha', 'inicio_hora', 'monto_inicio', 'monto_estimado', 'ingresos', 'egresos')->where('caja_abierta', true)->first();
    //     return response()->json(["status" => "success", "message" => "Ingreso registrado!","data"=>$data]);
    // }





    // public function egreso(Request $request)
    // {
    //     $user_id = auth()->user()->creator_id;

    //     $validator = \Validator::make($request->all(), [
    //         'importe' => 'required|numeric|between:0.00,999999.99',
    //         'comentario' => 'nullable|string|min:0|max:2000'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()->all()]);
    //     }

    //     $caja_abierta = CajasDetalle::select('id')->where('caja_id', 1)->where('caja_abierta',true)->get();
    //     if (count($caja_abierta) == 0) {
    //         return response()->json(["status" => "success", "message" => "No exiten cajas abiertas!"]);
    //     }

    //     $array = array();
    //     $id = $caja_abierta[0]->id;
    //     $array["cajadetalle_id"] = $id;
    //     $array["user_id"] = 1;
    //     $array["es_ingreso"] = false;
    //     if (request()->importe)  $array["monto"] = request()->importe;
    //     if (request()->comentario) $array["comentario"] = request()->comentario;

    //     CajasIngresoEgreso::create($array);
    //     $egresos = CajasIngresoEgreso::select(\DB::raw("sum(monto) as monto"))->where("cajadetalle_id", $id)->where("es_ingreso", false)->get();
    //     CajasDetalle::where("caja_abierta",true)->update(["egresos" => $egresos[0]->monto]);
    //     CajasDetalle::where("caja_abierta",true)->decrement("monto_estimado" ,$egresos[0]->monto);

    //     $data = CajasDetalle::select('id', 'inicio_fecha', 'inicio_hora', 'monto_inicio', 'monto_estimado', 'ingresos', 'egresos')->where('caja_abierta', true)->first();

    //     return response()->json(["status" => "success", "message" => "Egreso registrado!","data"=>$data]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    //     $user_id = auth()->user()->id;
    //     $caja = $request->validate([
    //         'caja' => 'required|string|max:50',
    //     ]);


    //     $caja = request(['caja']);

    //     Cajas::create([
    //         'caja' => $caja['caja'],
    //         'creator_id' => $user_id
    //     ]);

    //     return response()->json(["status" => "success", "message" => "Caja creada!"]);
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cajas  $cajas
     * @return \Illuminate\Http\Response
     */
    // public function show($caja)
    // {
    //     //
    //     $creator_id = auth()->user()->creator_id;
    //     $cajas = array();
    //     if ($creator_id) {
    //         $cajas = Cajas::select('id', 'caja', 'habilitado', 'created_at', 'updated_at')
    //             ->where("id", $caja)->where("eliminado", false)
    //             ->where("creator_id", $creator_id)->first();
    //     }
    //     return response()->json(["status" => "success", "caja" => $cajas]);
    // }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cajas  $cajas
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $caja)
    // {
    //     //
    //     $creator_id = auth()->user()->creator_id;

    //     $cajas = $request->validate([
    //         'caja' => 'required|string|max:50',
    //         'habilitado' => 'required|boolean|max:50',
    //     ]);

    //     $cajas = request(['caja', 'habilitado']);

    //     $s = Cajas::where('id', $caja)->where('creator_id', $creator_id)->where("eliminado", false)->update([
    //         'caja' => $cajas['caja'],
    //         'habilitado' => $cajas['habilitado'],
    //     ]);

    //     if ($s) {
    //         return response()->json(["status" => "success", "message" => "Editado!"]);
    //     }

    //     return response()->json(["status" => "error", "message" => "Caja no existe!"]);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cajas  $cajas
     * @return \Illuminate\Http\Response
     */
    // public function destroy($caja)
    // {
    //     //
    //     $creator_id = auth()->user()->creator_id;
    //     $s = Cajas::where('id', $caja)->where('creator_id', $creator_id)->update([
    //         "eliminado" => true
    //     ]);
    //     if ($s) {
    //         return response()->json([
    //             "status" => "sucess",
    //             "message" => "Se elimno correctamente!"
    //         ]);
    //     }
    //     return response()->json(["status" => "error", "message" => "Caja no existe!"]);
    // }
}
