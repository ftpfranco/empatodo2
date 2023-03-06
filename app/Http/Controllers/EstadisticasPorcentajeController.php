<?php

namespace App\Http\Controllers;

use App\Ventas;
use Illuminate\Http\Request;

class EstadisticasPorcentajeController extends Controller
{
    //

    public function index(Request $request){

        if($request->ajax()) {
            $filtro = request()->filtro? strtolower(request()->filtro) : "dia";
            
            if($filtro === "semana"){
                $semana = $this->semana();
                return response()->json($semana);
            }
           
            if($filtro === "mes"){
                // listado con los dias del mes y sus cantidad de ventas
                $mes = $this->mes();
                return response()->json($mes);
            }

            if($filtro === "anio"){
                // listado de la cantidad de ventas en cada mes del año
                $anio = $this->anio();
                return response()->json($anio);
            }

            // listado de pedidos hoy
            $hoy = $this->hoy();
            return response()->json($hoy);
        }
        // return view( "estadisticas/index" );
        return view( "estadisticas.porcentaje_ventas" );

    }




    public function hoy(){
       
        // tipos de pago tipopago_id
        // 1	"Efectivo"
        // 2	"Tarjeta Debito"
        // 8	"Efectivo PedidosYa"
        // 9	"Credito PedidosYa"
        $ventasLocal =  Ventas::select(\DB::raw("count(*)   as cantidad"))
            ->whereIn("tipopago_id",[1,2])
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
            // ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
            ->first();

        $ventasPedidosYa =  Ventas::select(\DB::raw("count(*)  as cantidad"))
            ->whereIn("tipopago_id",[8,9])
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
            // ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
            ->first();
 
        $data= array();
        $data["categories"] = array("Ventas en Local","Ventas PedidosYa");
        $tmp = array();
        if($ventasLocal) {
            $tmp[0] = $ventasLocal["cantidad"] ;
        }
        if($ventasPedidosYa) {
            $tmp[1] = $ventasPedidosYa["cantidad"] ;
        }
        $data["ventas"] = array_values($tmp);

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

        $diasDeLaSemana = array();
        $diasDeLaSemana[$fechaInicio] = 0;
        $incementoUnDia = $fechaInicio;
        $cont = 1;
        while(true){ 
            $incementoUnDia = strtotime("$incementoUnDia +1 days");
            $incementoUnDia = date("Y-m-d",$incementoUnDia);
            $diasDeLaSemana[$incementoUnDia] = 0;
            $cont++;
            if($incementoUnDia == $fechaFin) break;
        }
       
        $ventasLocal =  Ventas::select(\DB::raw("count(*) as cantidad"))
             ->whereIn("tipopago_id",[1,2])
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), ">=",$fechaInicio)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "<=",$fechaFin)
            // ->groupBy(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->first();
 
        $ventasPedidosYa =  Ventas::select(\DB::raw("count(*) as cantidad"))
            ->whereIn("tipopago_id",[8,9])
            ->where("eliminado",false)
            ->whereBetween( \DB::raw("to_char(created_at::date,'yyyy-mm-dd')" ), [ $fechaInicio, $fechaFin ] )
            // ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->first();
       

        $data = array();
        $data["categories"] = array("Ventas en Local","Ventas PedidosYa");
        $tmp = array();
        if($ventasLocal) {
            $tmp[0] = $ventasLocal["cantidad"]  ;
        }
        if($ventasPedidosYa) {
            $tmp[1] = $ventasPedidosYa["cantidad"]  ;
        }
        $data["ventas"] = array_values($tmp);

        return $data;
       
     

    }

    public function mes(){

        $ventasLocal =  Ventas::select(\DB::raw("count(*) as cantidad"))
            ->whereIn("tipopago_id",[1,2])
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
            // ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
            ->first();

        $ventasPedidosYa =  Ventas::select(\DB::raw("count(*) as cantidad"))
            ->whereIn("tipopago_id",[8,9])
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
            // ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
            ->first();

        $data= array();
        $data["categories"] = array("Ventas en Local","Ventas PedidosYa");
        $tmp = array();
        if($ventasLocal) {
            $tmp[0] = $ventasLocal["cantidad"] ;
        }
        if($ventasPedidosYa) {
            $tmp[1] = $ventasPedidosYa["cantidad"] ;
        }
        $data["ventas"] = array_values($tmp);

        return $data;
    }

    public function anio(){
        
        $ventasLocal =  Ventas::select(\DB::raw(" count(*) as cantidad"))
            ->whereIn("tipopago_id",[1,2])
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
            // ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->first();

        $ventasPedidosYa =  Ventas::select(\DB::raw(" count(*) as cantidad"))
            ->whereIn("tipopago_id",[8,9])
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
            // ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->first();

        $data= array();
        $data["categories"] = array("Ventas en Local","Ventas PedidosYa");
        $tmp = array();
        if($ventasLocal) {
            $tmp[0] = $ventasLocal["cantidad"] ;
        }
        if($ventasPedidosYa) {
            $tmp[1] = $ventasPedidosYa["cantidad"] ;
        }
        $data["ventas"] = array_values($tmp);

        return $data;

    }








}
