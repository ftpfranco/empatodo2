<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;


class Notificacion extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "notificaciones";
    protected $fillable = [
        'id',"titulo",'descripcion',"nota", "articulo_id","user_id",'creator_id', 'eliminado','created_at','updated_at'
    ];

    
}
