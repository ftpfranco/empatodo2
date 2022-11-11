<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;

    protected $table="categorias";
    protected $fillable = [
       'id', 'categoria','user_id', 'eliminado','created_at','updated_at'
    ];
}
