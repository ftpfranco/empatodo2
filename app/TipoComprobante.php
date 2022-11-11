<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    //
    use HasApiTokens ,HasRoles;

    // tipos de facturas a,b, c 
    protected $table= "tipocomprobante";
    protected $fillable = [
        'id','tipo_comprobante','eliminado','created_at','updated_at'
    ];
}
