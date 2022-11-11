<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TipoIva extends Model
{
    //
    use HasApiTokens ,HasRoles;
    protected $table="tipoiva";
    protected $fillable = [
        'id','tipo_iva','eliminado','created_at','updated_at'
    ];
}
