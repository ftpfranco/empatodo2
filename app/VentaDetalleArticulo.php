<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class VentaDetalleArticulo extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;
    protected $table="ventas_detalle_articulo";
    protected $fillable = [
        'id','venta_id','articulo_id','articulo',"precio",'cantidad',"descuento",'subtotal', "comentario", 'creator_id','eliminado','created_at','updated_at'
    ];
}



