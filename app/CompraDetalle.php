<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "compra_detalle";
    protected $fillable = [
        'id','articulo',"precio_compra","precio_venta","cantidad","subtotal","comentario", 'eliminado',
        "articulo_id",'creator_id','compra_id','created_at','updated_at'
    ];
}


 