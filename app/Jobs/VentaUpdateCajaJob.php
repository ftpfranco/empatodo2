<?php

namespace App\Jobs;

use App\CajasDetalle;
use App\VentaDetallePago;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use phpDocumentor\Reflection\Types\Boolean;

class VentaUpdateCajaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $venta_id; 
    protected $fecha ;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($venta_id, $fecha)
    {
        //
        $this->venta_id = $venta_id;
        $this->fecha = $fecha;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $venta_id = $this->venta_id; 
        $fecha = $this->fecha ; 

        $montoEfectivo = VentaDetallePago::select(\DB::raw("sum(monto) as monto"))->where("venta_id", $venta_id) ->where("eliminado",false)->whereIn("tipopago_id", [1,8] )->first();
        if(  isset($montoEfectivo["monto"]) && $montoEfectivo["monto"] !==null ){
            CajasDetalle::where("caja_abierta", true)->where(\DB::raw("to_char(inicio_fecha,'yyyy-mm-dd')") , $fecha)->increment("monto_estimado", $montoEfectivo["monto"]);
        }


    }
}
