<?php

namespace App\Jobs;

use Pusher\Pusher;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VentaUpdatePusherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataPusher;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dataPusher)
    {
        //
        $this->dataPusher= $dataPusher;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $dataPusher = $this->dataPusher;
        try {
            $options = array(
                'cluster' => env("PUSHER_APP_CLUSTER"),
                'encrypted' => true
            );
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $pusher->trigger('pedidos-pendientes', 'App\Events\EventoPedidos', $dataPusher);
            //code...
        } catch (\Exception $th) {
            \Log::error($th->getMessage());
        }
        // end generar evento de pedido
        // try {
        //     event(new EventoPedidos( $dataPuher));
        // } catch (\Exception $th) {
        //     //throw $th;
        //     Log::error($th->getMessage());
        // }
        
    }
}
