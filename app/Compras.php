<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Compras  extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "compras";
    protected $fillable = [
        'id','user_id','proveedor_id','monto','fecha','descuento_porcentaje','descuento_importe','pago_completo',"comentario",'eliminado','creator_id', 'created_at','updated_at'
    ]; 
}


