<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "precios";
    protected $fillable = [
        'id','precio_neto_venta','precio_compra','precio_venta','precio_descuento_porc','precio_descuento_impor','estado',
        'user_id','creator_id','articulo_id','eliminado','created_at','updated_at'
    ];
}



