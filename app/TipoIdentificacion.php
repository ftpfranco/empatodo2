<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TipoIdentificacion extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;
    protected $table="tipoidentificacion";
    protected $fillable = [
        'id','tipo_identificacion','eliminado','created_at','updated_at'
    ];
}
