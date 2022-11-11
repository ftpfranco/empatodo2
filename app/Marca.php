<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "marca";
    protected $fillable = [
        'id','marca' ,'creator_id','eliminado','created_at','updated_at'
    ];
}
