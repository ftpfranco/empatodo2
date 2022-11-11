<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class IngresoTipo extends Model
{
    //
    // use HasApiTokens ,HasRoles;
    protected $table= "ingreso_tipo";
    protected $fillable = [
        'id','ingresotipo','creator_id','eliminado','created_at','updated_at'
    ];
}
