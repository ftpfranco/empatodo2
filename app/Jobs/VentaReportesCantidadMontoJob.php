<?php

namespace App\Jobs;

use App\Reportes;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VentaReportesCantidadMontoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fecha;
    protected $monto ;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fecha, $monto)
    {
        //
        $this->fecha = $fecha;
        $this->monto = $monto;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $fecha = $this->fecha;
        $total = $this->monto ;

        $mes_fecha = date("m", strtotime($fecha));
        $anio_fecha = date("Y", strtotime($fecha));
        Reportes::firstOrCreate(["mes" => $mes_fecha, "anio" => $anio_fecha, "eliminado" => false]);
        Reportes::where("mes", $mes_fecha)->where("anio",  $anio_fecha)->increment("monto_ventas", $total);
        Reportes::where("mes", $mes_fecha)->where("anio",  $anio_fecha)->increment("cantidad_ventas", 1);


    }
}
