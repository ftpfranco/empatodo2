<?php

namespace App\Jobs;

use Pusher\Pusher;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VentaStorePusherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataEvento;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dataEvento)
    {
        //
        $this->dataEvento = $dataEvento;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $dataEvento = $this->dataEvento;
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
            $pusher->trigger('pedidos-pendientes', 'App\Events\EventoPedidos', $dataEvento);
        } catch (\Exception $th) {
            Log::error($th);
        }

        // $d = array();
        // array_push($d,$dataEvento);
        // $success = event(new EventoPedidos( $dataEvento));
        // try {
        //     $d = array();
        //     array_push($d,$dataEvento);
        //     $d= $dataEvento;
        //     // event(new \App\Events\EventoPedidos($d));
        //     Event::dispatch(new EventoPedidos($dataEvento));
        // } catch (\Exception $th) {
        //     //throw $th;
        //     Log::error($th);
        // }

        

    }
}
