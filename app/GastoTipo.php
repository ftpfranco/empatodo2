<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class GastoTipo extends Model
{
    //
    // use HasApiTokens ,HasRoles;
    protected $table= "gasto_tipo";
    protected $fillable = [
        'id','gastotipo','creator_id','eliminado','created_at','updated_at'
    ];
}
