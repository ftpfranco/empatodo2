<?php

namespace App\Http\Controllers;

use App\Gasto;
use App\Reportes;
use App\GastoTipo;
use Illuminate\Http\Request;
// use Mews\Purifier\Facades\Purifier;

class GastoController extends Controller
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

        $sumagastos =  Gasto::select(\DB::raw("sum(monto) as total, count(*) as cantidad"))->where(\DB::raw("to_char( fecha, 'YYYY-MM-DD') "), date("Y-m-d"))->where("eliminado", false);
         
        $gastos = Gasto::select('gasto.id', 'gasto_tipo.gastotipo', "gasto.gastotipo_id", \DB::raw("to_char(gasto.fecha,'YYYY-MM-DD') fecha"), "gasto.monto", "gasto.comentario", \DB::raw("to_char(gasto.created_at, 'HH24:MI') hora"))
            ->leftjoin("gasto_tipo", "gasto_tipo.id", "=", "gasto.gastotipo_id")
            ->where('gasto.eliminado', false)
            ->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), date("Y-m-d"))
            ;

        if (date("H:i") >= $t1_hora_desde && date("H:i") <= $t1_hora_hasta) {
            $campana = true;
            $sumagastos = $sumagastos ->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), ">=", $t1_hora_desde)->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), "<=", $t1_hora_hasta)->first();
            $gastos = $gastos  ->where(\DB::raw("TO_CHAR(gasto.created_at, 'HH24:MI') "), ">=", $t1_hora_desde)->where(\DB::raw("TO_CHAR(gasto.created_at, 'HH24:MI') "), "<=", $t1_hora_hasta) ;
            $gastos = $gastos  ->orderby("gasto.id", "desc")   ->paginate(15);
        }

        if (date("H:i") >= $t2_hora_desde && date("H:i") <= $t2_hora_hasta) {
            $campana = true;
            $sumagastos = $sumagastos ->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), ">=", $t2_hora_desde)->where(\DB::raw("TO_CHAR(created_at, 'HH24:MI') "), "<=", $t2_hora_hasta) ->first();
            $gastos = $gastos  ->where(\DB::raw("TO_CHAR(gasto.created_at, 'HH24:MI') "), ">=", $t2_hora_desde)->where(\DB::raw("TO_CHAR(gasto.created_at, 'HH24:MI') "), "<=", $t2_hora_hasta) ;
            $gastos = $gastos  ->orderby("gasto.id", "desc")   ->paginate(15);
            
        }

        $tipogasto = GastoTipo::select("id", "gastotipo")->where("eliminado", false)->pluck("gastotipo", "id");

        if($campana == false){ $gastos =array(); $sumagastos = array(); }
        return view("gastos.index", compact("gastos", "sumagastos", "tipogasto"));
    }


    public function filtro(Request $request)
    {


        $validator = \Validator::make($request->all(), [
            'fechadesde' => 'nullable|date',
            'fechahasta' => 'nullable|date',
            'tipogasto' => 'nullable|numeric',
        ],[
            "fechadesde.date" => "La Fecha Desde ingresada no es válido",
            "fechahasta.date" => "La Fecha Hasta ingresada no es válido",
            "tipogasto.numeric" => "La Categoria de Egreso no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $fechadesde = request()->fechadesde ? request()->fechadesde : date("Y-m-d");
        $fechahasta = request()->fechahasta ? request()->fechahasta : date("Y-m-d");
        $tipogasto = request()->tipogasto ? request()->tipogasto : null;
        
        $sumagastos =  Gasto::select(\DB::raw("sum(monto) as total, count(*) as cantidad")) ->where("eliminado", false);

        $gastos = Gasto::select('gasto.id', 'gasto_tipo.gastotipo', "gasto.gastotipo_id", \DB::raw("to_char(gasto.fecha,'YYYY/MM/DD') fecha"), "gasto.monto", "gasto.comentario" , \DB::raw("to_char(gasto.created_at, 'HH24:MI') hora") )
            ->leftjoin("gasto_tipo", "gasto_tipo.id", "=", "gasto.gastotipo_id")
            ->where('gasto.eliminado', false);
        // $ventas = $ventas->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), ">=", $fecha_desde)->where(\DB::raw("to_char( ventas.fecha, 'YYYY-MM-DD') "), "<=", $fecha_hasta);

        if ($fechadesde !== null && $fechahasta !== null) {
            // $gastos = $gastos->whereBetween("gasto.fecha", [$fechadesde, $fechahasta]);
            $gastos = $gastos   ->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fechadesde)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta);
            $sumagastos = $sumagastos ->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fechadesde)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta) ;
        }
        if ($fechadesde !== null && $fechahasta == null) {
            // $gastos = $gastos->whereBetween("gasto.fecha", [$fechadesde, $fechadesde]);
            $gastos = $gastos->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fechadesde)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fechadesde);
            $sumagastos = $sumagastos ->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fechadesde)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fechadesde) ;

        }
        if ($fechadesde == null && $fechahasta !== null) {
            // $gastos = $gastos->whereBetween("gasto.fecha", [$fechahasta, $fechahasta]);
            $gastos = $gastos->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fechahasta)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta);
            $sumagastos = $sumagastos ->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fechahasta)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fechadesde) ;

        }
        if ($fechadesde == null && $fechahasta == null) {
            $fechadesde = $fechahasta = date("Y-m-d");
            // $gastos = $gastos->whereBetween("gasto.fecha", [$fechahasta, $fechahasta]);
            $gastos = $gastos->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fechahasta)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta);
            $sumagastos = $sumagastos ->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), ">=", $fechahasta)->where(\DB::raw("to_char( gasto.fecha, 'YYYY-MM-DD') "), "<=", $fechahasta) ;

        }


        if ($tipogasto !== null) {
            $gastos = $gastos ->where("gasto.gastotipo_id", $tipogasto);
            $sumagastos = $sumagastos ->where("gasto.gastotipo_id", $tipogasto);  

        }

        $gastos = $gastos
            ->orderby("gasto.id", "desc")
            ->paginate(15);

        $sumagastos = $sumagastos ->first();

        $con_fecha = true;
        return response()->json([view("gastos.index_data", compact("gastos","con_fecha"))->render(), $sumagastos]);
    }


    public function editar(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            "id" => "required|numeric",
            'fecha' => 'nullable|date',
            'gastotipo' => 'required|numeric|max:100',
            'monto' => 'required|numeric|max:999999.99',
            'comentario' => 'nullable|string|max:1000',
        ],[
            "id.required" => "El Egreso ingresado no es válido",
            "id.numeric" => "El Egreso ingresado no es válido",
            "gastotipo.required" => "La Categoria de Egreso no es válido",
            "monto.required" => "El Monto ingreado no es válido",
            "monto.max" => "El Monto ingresado no es válido",
            "comentario.max" => "El Comentario ingresado no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=> "error",'message' => $validator->errors()->all()]);
        }
        $user_id = auth()->user()->id;
        $data = array();
        $id =  request()->id;
        $fecha =  request()->fecha;
        $gastotipo = request()->gastotipo;
        $monto = request()->monto;
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

        $gasto = Gasto::select("id", "fecha", "monto")->where("id", $id)->where("eliminado", false)->first();
        $gastotipo_name = GastoTipo::select("gastotipo")->where("id", $gastotipo)->where("eliminado", false)->first();
        if (!$gasto) return response()->json(["status" => "error", "message" => "Error, no se pudo guardar!"]);
        if (!$gastotipo_name) return response()->json(["status" => "error", "message" => "Error, no se pudo guardar!"]);

        // decrementar reportes

        $mes_fecha = date("m", strtotime($gasto["fecha"]));
        $anio_fecha = date("Y", strtotime($gasto["fecha"]));
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_egresos", $gasto["monto"]);


        $data = array();
        $data["fecha"] = $fecha;
        $data["gastotipo_id"] = $gastotipo;
        $data["monto"] = $monto;
        $data["user_id"] = $user_id;
        if($comentario) $data["comentario"] = $comentario;

        $d = Gasto::where("id", $id)->where("eliminado", false)->update($data);

        $data["id"] = $id;
        $data["gastotipo"] = $gastotipo_name["gastotipo"];


        $mes_fecha = date("m", strtotime($fecha));
        $anio_fecha = date("Y", strtotime($fecha));
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("monto_egresos", $monto);

        unset($data["user_id"]);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Editado!", "data" => $data]);
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
        //
        $validator = \Validator::make($request->all(), [
            'fecha' => 'nullable|date',
            'gastotipo' => 'required|numeric|max:100',
            'monto'  => "required|numeric|max:999999.99",
            'comentario' => 'nullable|string|max:1000',
        ],[
            "fecha.date" => "La Fecha ingresada no es válida",
            "gastotipo.required" => "La Categoria de Egreso no es válida",
            "monto.required" => "El Monto ingresado no es válido",
            "monto.numeric" => "El Monto ingresado no es válido",
            "monto.max" => "El Monto ingresado no es válido",
            "comentario.max" => "El Comentario ingresado no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $user_id = auth()->user()->id;
        $data = array();
        $fecha =  trim(request()->fecha) ? trim(request()->fecha) : date("Y-m-d");
        $gastotipo = request()->gastotipo;
        $monto = trim(request()->monto);
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
        $gastotipo_name = GastoTipo::select("gastotipo")->where("id", $gastotipo)->where("eliminado", false)->first();
        if (!$gastotipo_name) return response()->json(["status" => "error", "message" => "Error !"]);

        $data = array();
        $data["fecha"] = $fecha;
        $data["gastotipo_id"] = $gastotipo;
        $data["monto"] = $monto;
        $data["user_id"] = $user_id;
        if( $comentario ) $data["comentario"] = $comentario;

        $d = Gasto::create($data);
        $data["hora"] =  date("H:i", strtotime($d["created_at"]));
        unset($data["user_id"]);
        $t1_hora_desde = "08:30";
        $t1_hora_hasta = "17:00";

        $t2_hora_desde = "17:00";
        $t2_hora_hasta = "23:59";

        $data["id"] = $d->id;
        $data["gastotipo"] = $gastotipo_name["gastotipo"];

        $hora = date("H:i",strtotime($d["created_at"]));
        if( $fecha !== date("Y-m-d",strtotime($d["created_at"]))  ){
            $data = null;
        }
        if(!($hora>=$t1_hora_desde && $hora<= $t2_hora_hasta) ){
            $data = null;
        }

        unset($d["created_at"]);
        unset($d["updated_at"]);

        $mes_fecha = date("m", strtotime($fecha));
        $anio_fecha = date("Y", strtotime($fecha));
        Reportes::firstOrCreate(["mes" => $mes_fecha, "anio" => $anio_fecha, "eliminado" => false]);
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("monto_egresos", $monto);
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->increment("cantidad_egresos", 1);


        if ($d && $data!==null) {
            return response()->json(["status" => "success", "message" => "Guardado!", "data" => $data]);
        }
        if ($d) {
            return response()->json(["status" => "success", "message" => "Guardado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error !"]);
    }












    public function delete(Request $request, $id)
    {
        //
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric',
        ],[
            "id.required" => "El Egreso ingresado no es válido",
            "id.numeric" => "El Egreso ingresado no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        if(!$request->ajax()) return redirect()->to("egresos");

        $d = Gasto::select("fecha", "monto")->where("eliminado", false)->where("id", $id)->first();

        if (!$d) return response()->json(["status" => "error", "message" => "Error, no se pudo eliminar!"]);

        Gasto::where("id", $id)->where("eliminado", false)->update([
            'eliminado' => true,
        ]);

        $fecha = $d["fecha"];
        $monto = $d["monto"];

        $mes_fecha = date("m", strtotime($fecha));
        $anio_fecha = date("Y", strtotime($fecha));
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_egresos", $monto);
        Reportes::where('eliminado', false)->where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("cantidad_egresos", 1);

        return response()->json(["status" => "success", "message" => "Eliminado!"]);
    }







}
