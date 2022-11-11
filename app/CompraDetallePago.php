<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class CompraDetallePago extends Model
{
    //
    // use HasApiTokens ,HasRoles;
    protected $table="compras_detalle_pago";
    protected $fillable = [
        // 'id','venta_id','tipopago_id','tipopago','monto',  'creator_id','eliminado','created_at','updated_at'
        'id','compra_id',"tipopago_id","monto","comentario",'eliminado','created_at','updated_at'
        // 'id','venta_id',"tipopago_id",'monto',"comentario",'creator_id','eliminado','created_at','updated_at'

    ];



}
