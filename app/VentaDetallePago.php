<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class VentaDetallePago extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;
    protected $table="ventas_detalle_pago";
    protected $fillable = [
        // 'id','venta_id','tipopago_id','tipopago','monto',  'creator_id','eliminado','created_at','updated_at'
        'id','venta_id',"tipopago_id",'monto',"comentario",'creator_id','eliminado','created_at','updated_at'
    ];



}
