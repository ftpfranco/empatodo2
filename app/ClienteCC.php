<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ClienteCC extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table="cliente_cc";
    protected $fillable = [
        'id','cliente_id','monto', 'eliminado','user_id','creator_id','created_at','updated_at'
    ];
}
