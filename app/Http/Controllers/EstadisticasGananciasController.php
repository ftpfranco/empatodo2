<?php

namespace App\Http\Controllers;

use App\VentaDetallePago;
use Illuminate\Http\Request;

class EstadisticasGananciasController extends Controller
{
    // ganancias por tipo de pago  
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
        return view( "estadisticas.ganancias_por_tipopago" );

    }




    public function hoy(){
        $horas = array();
        for ($j=1; $j <=24 ; $j++) {
            $i = str_pad($j, 2, "0", STR_PAD_LEFT);
            $horas[$i] = 0 ;
        }
        // 1	"Efectivo"
        // 2	"Tarjeta Debito"
        // 8	"Efectivo PedidosYa"
        // 9	"Credito PedidosYa"
        $totalEfectivo =  VentaDetallePago::select(\DB::raw("to_char(created_at::timestamp,'HH24') as fecha,sum(monto) as total"))
        ->where("tipopago_id",1)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
        ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->orderby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->get();

        $totalTDebito =  VentaDetallePago::select(\DB::raw("to_char(created_at::timestamp,'HH24') as fecha,sum(monto) as total"))
        ->where("tipopago_id",2)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
        ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->orderby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->get();

        $totalTCredito =  VentaDetallePago::select(\DB::raw("to_char(created_at::timestamp,'HH24') as fecha,sum(monto) as total"))
        ->where("tipopago_id",3)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
        ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->orderby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->get();

        $totalEfectivoPedidosYa =  VentaDetallePago::select(\DB::raw("to_char(created_at::timestamp,'HH24') as fecha,sum(monto) as total"))
        ->where("tipopago_id",8)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
        ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->orderby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->get();

        $totalCreditoPedidosYa =  VentaDetallePago::select(\DB::raw("to_char(created_at::timestamp,'HH24') as fecha,sum(monto) as total"))
        ->where("tipopago_id",9)
        ->where("eliminado",false)
        ->where(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')"), "=",date("Y-m-d"))
        ->groupby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->orderby(\DB::raw("to_char(created_at::timestamp,'HH24')") )
        ->get();

        $data= array();
        $data["categories"] = array_keys($horas);
        $data["efectivo"] = array();
        if(count($totalEfectivo)){
            $temp = $horas;
            foreach ($totalEfectivo as $key => $value) {
                $temp[$value["fecha"]] = $value["total"];
            }
            $data["efectivo"] = array_values($temp);
        }


        $data["debito"] = array();
        if(count($totalTDebito) >= 1 ){
            $temp = $horas;
            foreach ($totalTDebito as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["debito"] = array_values($temp);
        }

        $data["credito"] = array();
        if(count($totalTCredito) >= 1 ){
            $temp = $horas;
            foreach ($totalTCredito as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["credito"] = array_values($temp);
        }

        $data["efectivo_pedidosya"] = array();
        if(count($totalEfectivoPedidosYa)){
            $temp = $horas;
            foreach ($totalEfectivoPedidosYa as $key => $value) {
                $temp[$value["fecha"]] = $value["total"];
            }
            $data["efectivo_pedidosya"] = array_values($temp);
        }

        $data["credito_pedidosya"] = array();
        if(count($totalCreditoPedidosYa)){
            $temp = $horas;
            foreach ($totalCreditoPedidosYa as $key => $value) {
                $temp[$value["fecha"]] = $value["total"];
            }
            $data["credito_pedidosya"] = array_values($temp);
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
      
        // 1	"Efectivo"
        // 2	"Tarjeta Debito"
        // 3	"Tarjeta Credito"
        // 6	"Otro"
        // 8	"Efectivo PedidosYa"
        // 9	"Credito PedidosYa"
        $gananciasEfectivo =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",1)
            ->where("eliminado",false)
            ->whereBetween( \DB::raw("to_char(created_at::date,'yyyy-mm-dd')" ), [ $fechaInicio, $fechaFin ] )
            ->groupBy(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->get();

        $gananciasDebito =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",2)
            ->where("eliminado",false)
            ->whereBetween( \DB::raw("to_char(created_at::date,'yyyy-mm-dd')" ), [ $fechaInicio, $fechaFin ] )
            ->groupBy(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->get();

        $gananciasCredito =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",3)
            ->where("eliminado",false)
            ->whereBetween( \DB::raw("to_char(created_at::date,'yyyy-mm-dd')" ), [ $fechaInicio, $fechaFin ] )
            ->groupBy(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->get();

        $gananciasEfectivoPedidosYa =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",8)
            ->where("eliminado",false)
            ->whereBetween( \DB::raw("to_char(created_at::date,'yyyy-mm-dd')" ), [ $fechaInicio, $fechaFin ] )
            ->groupBy(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->get();

        $gananciasCreditoPedidosYa =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm-dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",9)
            ->where("eliminado",false)
            ->whereBetween( \DB::raw("to_char(created_at::date,'yyyy-mm-dd')" ), [ $fechaInicio, $fechaFin ] )
            ->groupBy(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm-dd')") )
            ->get();


        $data = array();
        $data["categories"] = $categories;
        $data["efectivo"] = array();
        if(count($gananciasEfectivo)){
            $temp = $diasDeLaSemana ;
            foreach ($gananciasEfectivo as $key => $value) {
                $temp[$value["fecha"]] =  $value["cantidad"];
            }
            $data["efectivo"]= array_values($temp );
        }

        $data["debito"] = array();
        if(count($gananciasDebito)){
            $temp = $diasDeLaSemana ;
            foreach ($gananciasDebito as $key => $value) {
                $temp[$value["fecha"]] =  $value["cantidad"];
            }
            $data["debito"]= array_values($temp );
        }

        $data["credito"] = array();
        if(count($gananciasCredito)){
            $temp = $diasDeLaSemana ;
            foreach ($gananciasCredito as $key => $value) {
                $temp[$value["fecha"]] =  $value["cantidad"];
            }
            $data["credito"]= array_values($temp );
        }

        $data["efectivo_pedidosya"] = array();
        if(count($gananciasEfectivoPedidosYa)){
            $temp = $diasDeLaSemana ;
            foreach ($gananciasEfectivoPedidosYa   as $key => $value) {
                $temp[$value["fecha"]] =  $value["cantidad"];
            }
            $data["efectivo_pedidosya"] = array_values($temp );
        }

        $data["credito_pedidosya"] = array();
        if(count($gananciasCreditoPedidosYa)){
            $temp = $diasDeLaSemana ;
            foreach ($gananciasCreditoPedidosYa   as $key => $value) {
                $temp[$value["fecha"]] =  $value["cantidad"];
            }
            $data["credito_pedidosya"] = array_values($temp );
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
        
        // 1	"Efectivo"
        // 2	"Tarjeta Debito"
        // 3	"Tarjeta Credito"
        // 6	"Otro"
        // 8	"Efectivo PedidosYa"
        // 9	"Credito PedidosYa"
        $gananciasEfectivo =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",1)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
            ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'dd')") )
            ->get();

        $gananciasDebito =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",2)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
            ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'dd')") )
            ->get();

        $gananciasCredito =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",3)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
            ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'dd')") )
            ->get();

        $gananciasEfectivoPedidosYa =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",8)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
            ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'dd')") )
            ->get();

        $gananciasCreditoPedidosYa =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'dd') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",9)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy-mm')"), "=",date("Y-m"))
            ->groupby(\DB::raw("to_char(created_at::date,'dd')") )
            ->orderby(\DB::raw("to_char(created_at::date,'dd')") )
            ->get();


        $data= array();
        $data["categories"] = array_keys($diasDelMes);
        $data["efectivo"] = array();
        if(count($gananciasEfectivo)){
            $temp = $diasDelMes;
            foreach ($gananciasEfectivo as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["efectivo"] = array_values($temp);
        }

        $data["debito"] = array();
        if(count($gananciasDebito)){
            $temp = $diasDelMes;
            foreach ($gananciasDebito as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["debito"] = array_values($temp);
        }

        $data["credito"] = array();
        if(count($gananciasCredito)){
            $temp = $diasDelMes;
            foreach ($gananciasCredito as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["credito"] = array_values($temp);
        }

        $data["efectivo_pedidosya"] = array();
        if(count($gananciasEfectivoPedidosYa)){
            $temp = $diasDelMes;
            foreach ($gananciasEfectivoPedidosYa as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["efectivo_pedidosya"] = array_values($temp);
        }

        $data["credito_pedidosya"] = array();
        if(count($gananciasCreditoPedidosYa)){
            $temp = $diasDelMes;
            foreach ($gananciasCreditoPedidosYa as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["credito_pedidosya"] = array_values($temp);
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
         
        // 1	"Efectivo"
        // 2	"Tarjeta Debito"
        // 3	"Tarjeta Credito"
        // 6	"Otro"
        // 8	"Efectivo PedidosYa"
        // 9	"Credito PedidosYa"
        $gananciasEfectivo =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",1)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
            ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->get();

        $gananciasDebito =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",2 )
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
            ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->get();
           
        $gananciasCredito =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",3 )
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
            ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->get();
        $gananciasEfectivoPedidosYa =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",8)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
            ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->get();
 
        $gananciasCreditoPedidosYa =  VentaDetallePago::select(\DB::raw("to_char(created_at::date,'yyyy-mm') as fecha,sum(monto) as cantidad"))
            ->where("tipopago_id",9)
            ->where("eliminado",false)
            ->where(\DB::raw("to_char(created_at::date,'yyyy')"), "=",date("Y"))
            ->groupby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->orderby(\DB::raw("to_char(created_at::date,'yyyy-mm')") )
            ->get();


        $data= array();
        $data["categories"] = $meses;
        $data["efectivo"] = array();
        if(count($gananciasEfectivo)){
            $temp = $anioIni;
            foreach ($gananciasEfectivo as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["efectivo"] = array_values($temp);
        }

        $data["debito"] = array();
        if(count($gananciasDebito)){
            $temp = $anioIni;
            foreach ($gananciasDebito as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["debito"] = array_values($temp);
        }

        $data["credito"] = array();
        if(count($gananciasCredito)){
            $temp = $anioIni;
            foreach ($gananciasCredito as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["credito"] = array_values($temp);
        }

        $data["efectivo_pedidosya"] = array();
        if(count($gananciasEfectivoPedidosYa)){
            $temp = $anioIni;
            foreach ($gananciasEfectivoPedidosYa as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["efectivo_pedidosya"] = array_values($temp);
        }
       
        $data["credito_pedidosya"] = array();
        if(count($gananciasCreditoPedidosYa)){
            $temp = $anioIni;
            foreach ($gananciasCreditoPedidosYa as $key => $value) {
                $temp[$value["fecha"]] = $value["cantidad"];
            }
            $data["credito_pedidosya"] = array_values($temp);
        }

        return $data;

    }















}
