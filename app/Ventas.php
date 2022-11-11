<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;
    protected $table="ventas";
    protected $fillable = [
        'id','fecha','hora',"cliente",'punto_venta','codigo','cliente_id','user_id','monto','descuento_porcentaje',"tipopago_id",
        'descuento_importe',"total_recibido",'cae','comentario',"detalle",'pago_completo','eliminado','creator_id',"caja_id","tipoenvio_id",'created_at','updated_at'
    ];
}


