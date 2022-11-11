<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "proveedor";
    
    protected $fillable = [
        'id','nombre','email','tipo_identificacion_id','nro_dni','telefono',
        'localidad','direccion','eliminado', "habilitado",
        'created_at','updated_at'
    ];
}



