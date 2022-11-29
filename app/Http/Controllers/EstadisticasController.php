<?php

namespace App\Http\Controllers;

use App\User;
use App\Turno;
use App\ArticuloPorDia;
use App\Ventas;
use Illuminate\Http\Request;

class EstadisticasController extends Controller
{
    public function index(Request $request){

        if($request->ajax()) {
            $filtro = request()->filtro? strtolower(request()->filtro) : "dia";
            
            if($filtro == "semana"){
                $semana = $this->semana();
                return response()->json($semana);
            }
           
            if($filtro == "mes"){
                // listado con los dias del mes y sus cantidad de ventas
                $mes = $this->mes();
                return response()->json($mes);
            }

            if($filtro == "anio"){
                // listado de la cantidad de ventas en cada mes del año
                $anio = $this->anio();
                return response()->json($anio);
            }

            // listado de pedidos hoy
            $hoy = $this->hoy();
            return response()->json($hoy);
        }
        return view( "estadisticas/index" );

    }

    public function hoy(){
        $horas = array();
        for ($j=1; $j <=24 ; $j++) {
            $i = str_pad($j, 2, "0", STR_PAD_LEFT);
            $horas[$i] = 0 ;
        }

        $cantPreparacion =  Ventas::select(\DB::raw("to_char(created_at::timestamp,'HH24') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",2)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
        ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->orderby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->get();

        $cantEnviado =  Ventas::select(\DB::raw("to_char(created_at::timestamp,'HH24') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",3)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
        ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->orderby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->get();

        // dd($cantEnviado);
        $cantCancelado =  Ventas::select(\DB::raw("to_char(created_at::timestamp,'HH24') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",4)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
        ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->orderby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->get();

        $data= array();
        $data["categories"] = array_keys($horas);
        $data["preparacion"] = array();
        if(count($cantPreparacion)){
            $temp = $horas;
            foreach ($cantPreparacion as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["preparacion"] = array_values($temp);
        }

        $data["enviado"] = array();
        if(count($cantEnviado)){
            $temp = $horas;
            foreach ($cantEnviado as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["enviado"] = array_values($temp);
        }

        $data["cancelado"] = array();
        if(count($cantCancelado) >= 1 ){
            $temp = $horas;
            foreach ($cantCancelado as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["cancelado"] = array_values($temp);
        }

        return $data;
    }

    public function semana(){
        // SEMANA
        // echo date("Y-m-d");
        $diaSemana = date("w")  ;
        $cantDias = strtotime("-" .$diaSemana ." days"); # cant de dias restar
        $fechaInicio = date("Y-m-d", $cantDias); # fecha de inicio
        $cantDiasPos = strtotime("+" . ( 6 - date("w")  )." days"); # cant dias posteriores 
        $fechaFin = date("Y-m-d",$cantDiasPos);

        // print_r( "Fecha Inicio semana ".$fechaInicio ."\n");
        // print_r( "Fecha Fin    semana ".$fechaFin ."\n");
        $categories = array();

        $diasDeLaSemana = array();
        $diasDeLaSemana[$fechaInicio] = 0;
        $incementoUnDia = $fechaInicio;
        $diasNombres = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
        $diaName = $diasNombres[0] . " " .$fechaInicio ; 
        array_push($categories,$diaName) ;
        $cont = 1;
        while(true){ 
            $incementoUnDia = strtotime("$incementoUnDia +1 days");
            $incementoUnDia = date("Y-m-d",$incementoUnDia);
            $diasDeLaSemana[$incementoUnDia] = 0;
            $diaName = $diasNombres[$cont] . " " .$incementoUnDia ; 
            array_push($categories,$diaName) ;
            $cont++;
            if($incementoUnDia == $fechaFin) break;
        }
        
         
        // $ventasConTipoPedidoOrdenado =  Ventas::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,count(*) as cantidad"))
        //     ->where("tipoenvio_id",1)
        //     ->where("eliminado",false)
        //     ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), ">=",$fechaInicio)
        //     ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "<=",$fechaFin)
        //     ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
        //     ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
        //     ->get();
        $ventasConTipoPedidoEnPreparacion =  Ventas::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,count(*) as cantidad"))
            ->where("tipoenvio_id",2)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), ">=",$fechaInicio)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "<=",$fechaFin)
            ->groupBy(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->get();
        $ventasConTipoPedidoEnviado =  Ventas::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,count(*) as cantidad"))
            ->where("tipoenvio_id",3)
            ->where("eliminado",false)
            // ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), ">=",$fechaInicio)
            // ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "<=",$fechaFin)
            ->whereBetween( \DB::raw("to_char(created_at::date,'yyyy-mm-dd')" ), [ $fechaInicio, $fechaFin ] )
            ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->get();
        $ventasConTipoPedidoCancelado =  Ventas::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,count(*) as cantidad"))
            ->where("tipoenvio_id",4)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), ">=",$fechaInicio)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "<=",$fechaFin)
            ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->get();


        $data = array();
        $data["categories"] = $categories;
        $data["ordenado"] = array();
        // if( count($ventasConTipoPedidoOrdenado) ){
        //     $temp = $diasDeLaSemana ;
        //     foreach ($ventasConTipoPedidoOrdenado as $key => $value) {
        //         $temp[$value["fecha"]] =  $value["cantidad"];
        //     }
        //     $data["ordenado"] =  array_values($temp );
        // }

        $data["preparacion"] = array();
        if(count($ventasConTipoPedidoEnPreparacion)){
            $temp = $diasDeLaSemana ;
            foreach ($ventasConTipoPedidoEnPreparacion as $key => $value) {
                $temp[$value["fecha"]] =  $value["cantidad"];
            }
            $data["preparacion"]= array_values($temp );
        }

        $data["enviado"] = array();
        if(count($ventasConTipoPedidoEnviado)){
            $temp = $diasDeLaSemana ;
            foreach ($ventasConTipoPedidoEnviado   as $key => $value) {
                $temp[$value["fecha"]] =  $value["cantidad"];
            }
            $data["enviado"] = array_values($temp );
        }

        $data["cancelado"] = array();
        if(count($ventasConTipoPedidoCancelado)){
            $temp = $diasDeLaSemana ;
            foreach ($ventasConTipoPedidoCancelado as $key => $value) {
                $temp[$value["fecha"]] =  $value["cantidad"];
            }
            $data["cancelado"] = array_values($temp );
        }
         
       
        return $data;
     

    }

    public function mes(){
        $diasDelMes = array();
        
        for ($j=1; $j <=12 ; $j++) {
            // 30 dias - noviembre -abril -junio- septiembre
            if(in_array($j, array(4,6,9,11))){ 
                for ($i=1; $i <= 30 ; $i++) { 
                    $tm = strtotime($i);
                    $tm = date("d",$tm); 
                    $i = str_pad($i, 2, "0", STR_PAD_LEFT);
                    $diasDelMes[$i] = 0 ;
                }
                break;
            }
            if($j == 2){
                for ($i=1; $i <= 29 ; $i++) { 
                    $tm = strtotime($i);
                    $tm = date("d",$tm); 
                    $i = str_pad($i, 2, "0", STR_PAD_LEFT);
                    $diasDelMes[$i] = 0 ;
                }
                break; 
            }
            for ($i=1; $i <= 31 ; $i++) { 
                $tm = strtotime($i);
                $tm = date("d",$tm); 
                $i = str_pad($i, 2, "0", STR_PAD_LEFT);
                $diasDelMes[$i] = 0 ;
            }
            break; 
        }
        

        $cantPreparacion =  Ventas::select(\DB::raw("to_char(created_at::date,'dd') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",2)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
        ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
        ->orderby(\DB::raw("to_char(created_at::date,'dd')") )
        ->get();

        $cantEnviado =  Ventas::select(\DB::raw("to_char(created_at::date,'dd') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",3)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
        ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
        ->orderby(\DB::raw("to_char(created_at::date,'dd')") )
        ->get();

        // dd($cantEnviado);
        $cantCancelado =  Ventas::select(\DB::raw("to_char(created_at::date,'dd') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",4)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
        ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
        ->orderby(\DB::raw("to_char(created_at::date,'dd')") )
        ->get();

        $data= array();
        $data["categories"] = array_keys($diasDelMes);
        $data["preparacion"] = array();
        if(count($cantPreparacion)){
            $temp = $diasDelMes;
            foreach ($cantPreparacion as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["preparacion"] = array_values($temp);
        }

        $data["enviado"] = array();
        if(count($cantEnviado)){
            $temp = $diasDelMes;
            foreach ($cantEnviado as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["enviado"] = array_values($temp);
        }

        $data["cancelado"] = array();
        if(count($cantCancelado)){
            $temp = $diasDelMes;
            foreach ($cantCancelado as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["cancelado"] = array_values($temp);
        }

        return $data;
    }

    public function anio(){
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
        $anioIni = array();
        for ($i=1; $i <=12 ; $i++) {
            $tm = strtotime(date("Y-").$i);
            $tm = date("Y-m",$tm); 
            $anioIni[$tm] = 0 ;
        }
        // echo "<pre>";
        // print_r($anioIni);
        // die();
        // $cantOrdenados =  Ventas::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,count(*) as cantidad"))
        // ->where("tipoenvio_id",1)
        // ->where("eliminado",false)
        // ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
        // ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
        // ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
        // ->get();

        $cantPreparacion =  Ventas::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",2)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
        ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
        ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
        ->get();

        $cantEnviado =  Ventas::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",3)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
        ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
        ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
        ->get();

        $cantCancelado =  Ventas::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,count(*) as cantidad"))
        ->where("tipoenvio_id",4)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
        ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
        ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
        ->get();



        $data= array();
        $data["categories"] = $meses;
        // $data["ordenado"] = array();
        // if(count($cantOrdenados)){
        //     $temp = $anioIni;
        //     foreach ($cantOrdenados as $key => $value) {
        //         $temp[$value["fecha"]] = $value["cantidad"];
        //     }
        //     $data["ordenado"] = array_values($temp);
        // }

        $data["preparacion"] = array();
        if(count($cantPreparacion)){
            $temp = $anioIni;
            foreach ($cantPreparacion as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["preparacion"] = array_values($temp);
        }

        $data["enviado"] = array();
        if(count($cantEnviado)){
            $temp = $anioIni;
            foreach ($cantEnviado as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["enviado"] = array_values($temp);
        }

        $data["cancelado"] = array();
        if(count($cantCancelado)){
            $temp = $anioIni;
            foreach ($cantCancelado as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["cancelado"] = array_values($temp);
        }

        return $data;

    }

    public function articulos()
    {
        //
        // $user_id = auth()->user()->id;
        // $turnos = Turno::select('time1_start' ,"time1_end","time2_start","time2_end")->where("user_id",$user_id)->first();
        
        // $turno1_start = $turnos["time1_start"];
        // $turno1_end = $turnos["time1_end"];

        // $turno2_start = $turnos["time2_start"];
        // $turno2_end = $turnos["time2_end"];

        

        $articulos_t1 = ArticuloPorDia::select("articulos.articulo","articulos_vendidos_por_dia.cantidad")
        ->leftjoin("articulos","articulos.id","=","articulos_vendidos_por_dia.articulo_id")
        ->where("articulos_vendidos_por_dia.dia",date("d"))
        ->where("articulos_vendidos_por_dia.anio",date('Y'))
        ->where("articulos_vendidos_por_dia.mes",date('m')) 
        ->where("articulos_vendidos_por_dia.t1",true)
        ->orderby("articulos_vendidos_por_dia.articulo_id","asc")
        ->get();


        // $articulos_t2 = ArticuloPorDia::select("articulo_id","cantidad")->where("dia",date("d"))->where("anio",date('Y'))->where("mes",date('m')) ->where("t2",true)->get();

        $articulos_t2 = ArticuloPorDia::select("articulos.articulo","articulos_vendidos_por_dia.cantidad")
        ->leftjoin("articulos","articulos.id","=","articulos_vendidos_por_dia.articulo_id")
        ->where("articulos_vendidos_por_dia.dia",date("d"))
        ->where("articulos_vendidos_por_dia.mes",date('m')) 
        ->where("articulos_vendidos_por_dia.anio",date('Y'))
        ->where("articulos_vendidos_por_dia.t2",true)
        ->orderby("articulos_vendidos_por_dia.articulo_id","asc")
        ->get();


        // dd($articulos_t1);
        // dd($articulos_t2);

        return view("estadisticas/cant_articulos_vendidos_por_dia",compact("articulos_t1","articulos_t2"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
