<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;


class CajasDetalleH extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;

    protected $table= "cajas_detalle_h";
    protected $fillable = [
        'id','cajadetalle_id','inicio_fecha','cierre_fecha','inicio_hora','cierre_hora','monto_inicio','monto_estimado','monto_real','diferencia',
        'estado', 
        'eliminado','created_at','updated_at'
    ];

    
}

 