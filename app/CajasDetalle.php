<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;


class CajasDetalle extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;

    protected $table= "cajas_detalle";
    protected $fillable = [
        'id','caja_id','user_id','inicio_fecha','cierre_fecha','inicio_hora','cierre_hora','monto_inicio','monto_estimado','monto_real','diferencia',
        'ingresos','egresos','estado','caja_abierta',
        'eliminado','created_at','updated_at'
    ];

    
}

