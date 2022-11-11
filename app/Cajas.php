<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;


class Cajas extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;

    protected $table= "cajas";
    protected $fillable = [
        'id','caja','creator_id','habilitado','eliminado','created_at','updated_at'
    ];

    
}
