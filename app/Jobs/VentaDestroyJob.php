<?php

namespace App\Jobs;

use App\Ventas;
use App\Articulo;
use App\Reportes;
use App\CajasDetalle;
use App\ArticuloPorDia;
use App\VentaDetallePago;
use App\VentaDetalleArticulo;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VentaDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $venta;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ventas $venta)
    {
        //
        $this->venta = $venta;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $venta = $this->venta;

        $t1_hora_desde = "07:30";
        $t1_hora_hasta = "16:00";

        $t2_hora_desde = "16:01";
        $t2_hora_hasta = "23:59";

        // decrementar caja 
        // tipopago_id 1, 8 // efectivo y efectivo pedidos ya
        $tipopago_id    = $venta["tipopago_id"];
        $total_recibido = $venta["total_recibido"];
        $fecha          = $venta["fecha"];
        $venta_id       = $venta["id"];


        $montoEfectivo = VentaDetallePago::select(\DB::raw("sum(monto) as monto"))->where("venta_id", $venta_id) ->where("eliminado",false)->whereIn("tipopago_id", [1,8] )->first();
        if( isset($montoEfectivo["monto"]) && $montoEfectivo["monto"] !==null ){
            CajasDetalle::where("caja_abierta", true)->where(\DB::raw("to_char(inicio_fecha,'yyyy-mm-dd')") , $fecha)->decrement("monto_estimado", $montoEfectivo["monto"]);
        }
       

        $venta_detalle = VentaDetalleArticulo::select("cantidad", "articulo_id")->where("venta_id", $venta_id)->where("eliminado", false)->get();

        if ($venta_detalle) {
            foreach ($venta_detalle as $vd) {
                $cant_art = (int)$vd["cantidad"];
                Articulo::where("id", $vd["articulo_id"])->increment("stock", $vd["cantidad"]);
                // BEGIN ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 
                $dia = date("d");
                $mes = date("m");
                $anio = date("Y");
                if (date("H:i") >= $t1_hora_desde && date("H:i") <= $t1_hora_hasta) {
                    ArticuloPorDia::firstOrCreate(["articulo_id" => $vd["articulo_id"], "dia" => $dia, "mes" => $mes, "anio" => $anio, "t1" => true]);
                    ArticuloPorDia::where("dia", $dia)->where("mes", $mes)->where("anio",  $anio)->where("t1", true)->where("articulo_id", $vd["articulo_id"])->where("cantidad", '>', 0)->decrement("cantidad", $cant_art);
                }

                if (date("H:i") >= $t2_hora_desde && date("H:i") <= $t2_hora_hasta) {
                    ArticuloPorDia::firstOrCreate(["articulo_id" => $vd["articulo_id"], "dia" => $dia, "mes" => $mes, "anio" => $anio, "t2" => true]);
                    ArticuloPorDia::where("dia", $dia)->where("mes", $mes)->where("anio",  $anio)->where("t2", true)->where("articulo_id", $vd["articulo_id"])->where("cantidad", ">", 0)->decrement("cantidad", $cant_art);
                }
                // END ESTADISTICA: CANTIDAD ARTICULOS VENDIDOS POR TURNOS DEL DIA 
            }
            VentaDetalleArticulo::where("venta_id", $venta_id)->update(["eliminado" => true]);
        }
        $mes_fecha = date("m", strtotime($venta['fecha']));
        $anio_fecha = date("Y", strtotime($venta['fecha']));
        $monto = $venta['monto'];

        if ($monto !== null) {
            Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("monto_ventas", $monto);
            Reportes::where("mes", $mes_fecha)->where("anio", $anio_fecha)->decrement("cantidad_ventas", 1);
        }

        Ventas::where("id", $venta_id)->where("eliminado", false)->update(["eliminado" => true]);
    }
}
