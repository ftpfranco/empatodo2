<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Cliente  extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;

    protected $table= "cliente";
    protected $fillable = [
        'id','nombre','email','tipo_identificacion_id','nro_dni','telefono',
        'localidad','direccion','calle','nro_calle','piso','eliminado','tiene_ccorriente','creator_id',
        'comentario',
        'created_at','updated_at'
    ];
}

