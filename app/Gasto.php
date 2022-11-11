<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Gasto  extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "gasto";
    protected $fillable = [
        'id','comentario','monto','fecha','gastotipo_id',"tipopago_id",'user_id','creator_id','eliminado','created_at','updated_at'
    ];
}

