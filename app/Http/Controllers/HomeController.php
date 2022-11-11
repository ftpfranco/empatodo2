<?php

namespace App\Http\Controllers;

use App\Gasto;
use App\Ventas;
use App\Compras;
use App\Ingreso;
use App\Reportes;
use App\Notificacion;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
       
         
        if(auth()->user()->es_empleado){
            return redirect()->to("ventas-diarias");
        }
         
        if($request->ajax()){
            $compras = Reportes::select('monto_compras',"mes")->where('eliminado', false)->where("anio",date("Y"))->orderby("mes","asc")->pluck("monto_compras","mes")->toArray();
            $ventas =  Reportes::select('monto_ventas',"mes")->where('eliminado', false)->where("anio",date("Y"))->orderby("mes","asc")->pluck("monto_ventas","mes")->toArray();
            $ingresos = Reportes::select('monto_ingresos',"mes")->where('eliminado', false)->where("anio",date("Y"))->orderby("mes","asc")->pluck("monto_ingresos","mes")->toArray();
            $egresos = Reportes::select('monto_egresos',"mes")->where('eliminado', false)->where("anio",date("Y"))->orderby("mes","asc")->pluck("monto_egresos","mes")->toArray();

            $compras_ = array();
            $ventas_ = array();
            $ingresos_ = array();
            $egresos_ = array();

            for ($i=1; $i <=12 ; $i++) { 
                $compras_[$i] = isset($compras[$i])?$compras[$i]:0;
                $ventas_[$i] = isset($ventas[$i])?$ventas[$i]:0;
                $ingresos_[$i] = isset($ingresos[$i])?$ingresos[$i]:0;
                $egresos_[$i] = isset($egresos[$i])?$egresos[$i]:0;
            }
            
            $compras_ = array_values($compras_);
            $ventas_ = array_values($ventas_);
            $ingresos_ = array_values($ingresos_);
            $egresos_ = array_values($egresos_);
            return response()->json(["status" => "success","data"=>["compras"=>$compras_,"ventas"=>$ventas_,"ingresos"=>$ingresos_,"egresos"=>$egresos_]]);
        }


        $notificaciones =  Notificacion::select("id", "descripcion", "articulo_id")
            ->where("eliminado", false)
            ->orderby("id", "desc")->get();
        $_SESSION["notificaciones"] = $notificaciones;

        $cant_compras = Compras::select(\DB::raw("count(*) as cantidad, sum(monto) as monto "))->where(\DB::raw("to_char(fecha,'YYYY')"),'=',date("Y"))->where("eliminado",false)->first();
        $cant_ventas = Ventas::select(\DB::raw("count(*) as cantidad,sum(total_recibido) as monto "))->where("pago_completo",true)->where("tipoenvio_id",3)->where(\DB::raw("to_char(fecha,'YYYY')"),'=',date("Y"))->where("eliminado",false)->first();
        $cant_ingresos = Ingreso::select(\DB::raw("count(*) as cantidad, sum(monto) as monto"))->where(\DB::raw("to_char(fecha,'YYYY')"),'=',date("Y"))->where("eliminado",false)->first();
        $cant_egresos = Gasto::select(\DB::raw("count(*) as cantidad, sum(monto) as monto"))->where(\DB::raw("to_char(fecha,'YYYY')"),'=',date("Y"))->where("eliminado",false)->first();
 

        return view('home',compact("cant_compras","cant_ventas","cant_ingresos","cant_egresos"));
    }


}
