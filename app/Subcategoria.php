<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "subcategorias";
    protected $fillable = [
        'id','subcategoria','categoria_id','creator_id','eliminado','created_at','updated_at'
    ];
}
