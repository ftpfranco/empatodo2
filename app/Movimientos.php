<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    //

    use HasApiTokens ,HasRoles;

    protected $table= "movimientos";
    protected $fillable = [
        'id','cliente_id','tipopago_id','es_ingreso','monto','fecha','comentario','puede_eliminar',
        'eliminado',"venta_id",'user_id','creator_id','created_at','updated_at'
    ];

    
}
