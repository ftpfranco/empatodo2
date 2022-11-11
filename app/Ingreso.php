<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Ingreso  extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "ingreso";
    protected $fillable = [
        'id','ingresotipo_id','comentario','monto','fecha','user_id','creator_id','eliminado','created_at','updated_at'
    ];
}

