<?php

namespace App\Http\Controllers;

use App\Gasto;
use App\Ingreso;
use App\Reportes;
use App\GastoTipo;
use App\IngresoTipo;
use Illuminate\Http\Request;
// use Mews\Purifier\Facades\Purifier;

class IngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // 'id','tipogasto_id','comentario','monto','fecha','user_id','creator_id','eliminado','created_at','updated_at'

         // $turno  _mañana = "11:00 - 16:00";
         $t1_hora_desde = "08:30";
         $t1_hora_hasta = "17:00";
 
         $t2_hora_desde = "17:00";
         $t2_hora_hasta = "23:59";
         $campana = false;


        $sumaingresos =  Ingreso::select(\DB::raw("sum(monto) as total,count(*) as cantidad")) ->where(\DB::raw("to_char( fecha, 'YYYY-MM-DD') "), date("Y-m-d")) ->where("eliminado", false) ;

        $tipoingreso = IngresoTipo::select("id", "ingresotipo")->where("eliminado", false)->pluck("ingresotipo", "id");
        // dd($tipoingreso);
        $ingresos = Ingreso::select('ingreso.id', 'ingreso_tipo.ingresotipo', "ingreso.ingresotipo_id",\DB::raw("to_char(ingreso.fecha, 'YYYY/MM/DD') fecha")  , "ingreso.monto", "ingreso.comentario",   \DB::raw("to_char(ingreso.created_at, 'HH24:MI') hora"))
            ->leftjoin("ingreso_tipo", "ingreso_tipo.id", "=", "ingreso.ingresotipo_id")
            ->where('ingreso.eliminado', false)
            ->orderby("ingreso.id", "desc")
            ->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), date("Y-m-d"))
            ;


        if (date("H:i") >= $t1_hora_desde && date("H:i") <= $t1_hora_hasta) {
            $campana = true;
            $sumaingresos = $sumaingresos ->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), ">=", $t1_hora_desde)->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), "<=", $t1_hora_hasta)->first();
            $ingresos = $ingresos  ->where(\DB::raw("TO_CHAR(ingreso.created_at, 'HH24:MI') "), ">=", $t1_hora_desde)->where(\DB::raw("TO_CHAR(ingreso.created_at, 'HH24:MI') "), "<=", $t1_hora_hasta) ;
            $ingresos = $ingresos  ->orderby("ingreso.id", "desc")   ->paginate(15);
        }

        if (date("H:i") >= $t2_hora_desde && date("H:i") <= $t2_hora_hasta) {
            $campana = true;
            $sumaingresos = $sumaingresos ->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), ">=", $t2_hora_desde)->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), "<=", $t2_hora_hasta) ->first();
            $ingresos = $ingresos  ->where(\DB::raw("TO_CHAR(ingreso.created_at, 'HH24:MI') "), ">=", $t2_hora_desde)->where(\DB::raw("TO_CHAR(ingreso.created_at, 'HH24:MI') "), "<=", $t2_hora_hasta) ;
            $ingresos = $ingresos  ->orderby("ingreso.id", "desc")   ->paginate(15);
        }

        if($campana == false){ $ingresos =array(); $sumaingresos = array(); }


        return view("ingresos.index", compact("ingresos", "sumaingresos", "tipoingreso"));
    }


    public function filtro(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'fechadesde' => 'nullable|date',
            'fechahasta' => 'nullable|date',
            'tipoingreso' => 'nullable|numeric',
        ],[
            'fechadesde.date'=>"La Fecha Desde ingresada no es válido",
            'fechahasta.date'=>"La Fecha Hasta ingresada no es válido",
            'tipoingreso.numeric'=>"La Categoria de Ingreso no es válido",
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $fechadesde = request()->fechadesde ? request()->fechadesde : date("Y-m-d");
        $fechahasta = request()->fechahasta ? request()->fechahasta : date("Y-m-d");
        $tipoingreso = request()->tipoingreso ? request()->tipoingreso : null;

        $sumaingresos =  Ingreso::select(\DB::raw("sum(monto) as total, count(*) as cantidad")) ->where("eliminado", false);

        $ingresos = Ingreso::select('ingreso.id', 'ingreso_tipo.ingresotipo', "ingreso.ingresotipo_id" ,\DB::raw("to_char(ingreso.fecha, 'YYYY/MM/DD') fecha") ,   "ingreso.monto", "ingreso.comentario" , \DB::raw("to_char(ingreso.created_at, 'HH24:MI') hora") )
            ->leftjoin("ingreso_tipo", "ingreso_tipo.id", "=", "ingreso.ingresotipo_id")
            ->where('ingreso.eliminado', false);

        // if ($fechadesde !== null && $fechahasta !== null) {
        //     $ingresos = $ingresos->whereBetween("ingreso.fecha", [$fechadesde, $fechahasta]);
        // }
        // if ($fechadesde !== null && $fechahasta == null) {
        //     $ingresos = $ingresos->whereBetween("ingreso.fecha", [$fechadesde, $fechadesde]);
        // }
        // if ($fechadesde == null && $fechahasta !== null) {
        //     $ingresos = $ingresos->whereBetween("ingreso.fecha", [$fechahasta, $fechahasta]);
        // }

        // if ($tipoingreso !== null) {
        //     $ingresos = $ingresos->where("ingreso.ingresotipo_id", $tipoingreso);
        // }


        if ($fechadesde !== null && $fechahasta !== null) {
            // $gastos = $gastos->whereBetween("gasto.fecha", [$fechadesde, $fechahasta]);
            $ingresos = $ingresos   ->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), ">=", $fechadesde)->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta);
            $sumaingresos = $sumaingresos ->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), ">=", $fechadesde)->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta) ;
        }
        if ($fechadesde !== null && $fechahasta == null) {
            // $gastos = $gastos->whereBetween("ingreso.fecha", [$fechadesde, $fechadesde]);
            $ingresos = $ingresos->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), ">=", $fechadesde)->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), "<=", $fechadesde);
            $sumaingresos = $sumaingresos ->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), ">=", $fechadesde)->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), "<=", $fechadesde) ;

        }
        if ($fechadesde == null && $fechahasta !== null) {
            // $gastos = $gastos->whereBetween("ingreso.fecha", [$fechahasta, $fechahasta]);
            $ingresos = $ingresos->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), ">=", $fechahasta)->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta);
            $sumaingresos = $sumaingresos ->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), ">=", $fechahasta)->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), "<=", $fechadesde) ;

        }
        if ($fechadesde == null && $fechahasta == null) {
            $fechadesde = $fechahasta = date("Y-m-d");
            // $gastos = $gastos->whereBetween("ingreso.fecha", [$fechahasta, $fechahasta]);
            $ingresos = $ingresos->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), ">=", $fechahasta)->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta);
            $sumaingresos = $sumaingresos ->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), ">=", $fechahasta)->where(\DB::raw("to_char( ingreso.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta) ;

        }


        if ($tipoingreso !== null) {
            $ingresos = $ingresos ->where("ingreso.ingresotipo_id", $tipoingreso);
            $sumaingresos = $sumaingresos ->where("ingreso.ingresotipo_id", $tipoingreso);  
        }

        $ingresos = $ingresos
            ->orderby("ingreso.id", "desc")
            ->paginate(15);

        $sumaingresos = $sumaingresos ->first();
        $con_fecha = true;

        return response()->json([view("ingresos.index_data", compact("ingresos","con_fecha"))->render(), $sumaingresos]);
    }


    public function editar(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric',
            'fecha' => 'nullable|date',
            'monto' => 'nullable|numeric|max:999999.99',
            'tipoingreso' => 'nullable|numeric|max:99999',
            "comentario" => "nullable|string|max:50000"
        ],[
            "id.numeric"=>"El Ingreso no es válido",
            "fecha.date" => "La Fecha ingresada no es válido",
            "monto.max" => "El Monto ingresado no es válido",
            "tipoingreso.max" => "La Categoria de Ingreso no es válido",
            "comentario.max" => "El Comentario ingresado no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $user_id = auth()->user()->id;
        $id = request()->id;
        $fecha = request()->fecha ? request()->fecha : date('Y-m-d');
        $monto = request()->monto;
        $tipoingreso =  request()->tipoingreso;
        $comentario = !empty(trim(request()->comentario) )? trim(request()->comentario) : null ;


        if($comentario){
            // $comentario =  Purifier::clean($comentario);
            // $comentario = str_replace("&lt","",$comentario);
            // $comentario = str_replace("?","",$comentario);
            // $comentario = str_replace("\\","",$comentario);
            $comentario = str_replace("--","",$comentario);
            $comentario = str_replace("'","",$comentario);
            $comentario = trim($comentario);
        }

        $ingreso = Ingreso::select("id","monto","fecha")->where("id", $id)->where("eliminado", false)->first();
        $ingresotipo_name = IngresoTipo::select("ingresotipo")->where("id", $tipoingreso)->where("eliminado", false)->first();
        if (!$ingreso) return response()->json(["status" => "error", "message" => "Error guardar!"]);
        if (!$ingresotipo_name) return response()->json(["status" => "error", "message" => "Error, no se pudo guardar!"]);


        // reportescantidad_ingresos
        $mes_fecha = date("m", strtotime($fecha));
        $anio_fecha = date("Y", strtotime($fecha));
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_ingresos", $ingreso["monto"]);

        
        $data = array();
        $data["ingresotipo_id"] = $tipoingreso;
        $data["fecha"] = $fecha;
        $data["monto"] =  $monto;
        $data["user_id"] = $user_id;
        if($comentario) $data["comentario"]  = $comentario;

        $d = Ingreso::where("id", $id)->where("eliminado", false)->update($data);
        $data["id"] = $id;
        $data["ingresotipo"] = $ingresotipo_name["ingresotipo"];

        unset($data["user_id"]);
        // reportes
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("monto_ingresos", $monto);


        if ($d) {
            return response()->json(["status" => "success", "message" => "Editado!", "data" => $data]);
        }
        return response()->json(["status" => "error", "message" => "Error !"]);
    }





    public function delete(Request $request, $id)
    {
        //
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric',
        ],[
            "id.numeric"=>"El Ingreso no es válido",
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        if(!$request->ajax()) return redirect()->to("ingresos");

        $d = Ingreso::select("monto","fecha")->where("id", $id)->where("eliminado", false)->first();

        if (!$d) return response()->json(["status" => "error", "message" => "Error!"]);

        $monto = $d["monto"];
        $fecha = $d["fecha"];

        Ingreso::where("id", $id)->where("eliminado", false)->update([
            'eliminado' => true,
        ]);

        // reportes
        $mes_fecha = date("m", strtotime($fecha));
        $anio_fecha = date("Y", strtotime($fecha));
        Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_ingresos", $monto);
        Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("cantidad_ingresos", 1);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Eliminado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error !"]);

    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // 'id','tipogasto_id','comentario','monto','fecha','user_id','creator_id','eliminado','created_at','updated_at'

        $validator = \Validator::make($request->all(), [
            'fecha' => 'nullable|date',
            'tipoingreso' => 'required|numeric|max:100',
            'monto' => 'required|numeric|max:999999.99',
            'comentario' => 'nullable|string|max:1000',
        ],[
            "fecha.date"=>"La Fecha ingresada no es válido",
            "tipoingreso.required" => "Seleccioná un Tipo de Ingreso",
            "tipoingreso.numeric"=> "La Categoria de Ingreso no es válido",
            "tipoingreso.max" => "La Categoria de Ingreso no es válido",
            "comentario.max" => "El Comentario ingresado no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $user_id = auth()->user()->id;
        $data = array();
        $fecha =  request()->fecha ? request()->fecha : date("Y-m-d");
        $tipoingreso = request()->tipoingreso;
        $monto = request()->monto;
        $comentario = !empty(trim(request()->comentario) )? trim(request()->comentario) : null;

        if($comentario){
            // $comentario =  Purifier::clean($comentario);
            // $comentario = str_replace("&lt","",$comentario);
            // $comentario = str_replace("?","",$comentario);
            // $comentario = str_replace("\\","",$comentario);
            $comentario = str_replace("--","",$comentario);
            $comentario = str_replace("'","",$comentario);
            $comentario = trim($comentario);
        }

        $ingresotipo_name = IngresoTipo::select("ingresotipo")->where("id", $tipoingreso)->first();
        if (!$ingresotipo_name) return response()->json(["status" => "error", "message" => "Error, no se pudo guardar!"]);

        $data = array();
        $data["fecha"] = $fecha;
        $data["ingresotipo_id"] = $tipoingreso;
        $data["monto"] = $monto;
        $data["user_id"] = $user_id;
        if($comentario) $data["comentario"] = $comentario;

        $d = Ingreso::create($data);
        $data["hora"] =  date("H:i", strtotime($d["created_at"]));
        $data["id"] = $d->id;
        $data["ingresotipo"] = $ingresotipo_name["ingresotipo"];

        unset($data["user_id"]);
        
        $t1_hora_desde = "08:30";
        $t1_hora_hasta = "17:00";

        $t2_hora_desde = "17:00";
        $t2_hora_hasta = "23:59";
       
        $hora = date("H:i",strtotime($d["created_at"]));
        if( $fecha !== date("Y-m-d",strtotime($d["created_at"]))  ){
            $data = null;
        }
        if(!($hora>=$t1_hora_desde && $hora<= $t2_hora_hasta) ){
            $data = null;
        }

        unset($d["created_at"]);
        unset($d["updated_at"]);

        // reportes
        $mes_fecha = date("m", strtotime($fecha));
        $anio_fecha = date("Y", strtotime($fecha));
        Reportes::firstOrCreate(["mes"=>$mes_fecha,"anio"=>$anio_fecha,"eliminado"=>false]);
        Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("monto_ingresos", $monto);
        Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("cantidad_ingresos", 1);


        if ($d && $data!==null) {
            return response()->json(["status" => "success", "message" => "Guardado!", "data" => $data]);
        }

        if ($d ) {
            return response()->json(["status" => "success", "message" => "Guardado!" ]);
        }

        return response()->json(["status" => "error", "message" => "Error !"]);
    }
}
