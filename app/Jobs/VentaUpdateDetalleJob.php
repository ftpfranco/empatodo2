<?php

namespace App\Jobs;

use App\Ventas;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VentaUpdateDetalleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $venta_id ;
    protected $total ;
    protected $detalle; 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($venta_id, $total, $detalle)
    {
        //
        $this->venta_id = $venta_id;
        $this->total = $total;
        $this->detalle = $detalle;

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
        $total = $this->total;
        $detalle = $this->detalle;

        
        Ventas::where("id", $venta_id) ->where("eliminado", false)
        ->update(["monto" => $total, "detalle" => $detalle]);


    }
}
