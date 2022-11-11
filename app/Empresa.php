<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;


class Empresa extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "empresa";
    protected $fillable = [
        'id','nombre','cuit','email','telefono','whatsapp','provincia','localidad','direccion',"path_image","path_thumbnail","user_id",'creator_id','habilitado','eliminado','created_at','updated_at'
    ];

    
}
