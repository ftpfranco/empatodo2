<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ProveedorCC extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table="proveedor_cc";
    protected $fillable = [
        'id','proveedor_id','monto', 'eliminado','user_id','creator_id','created_at','updated_at'
    ];
}
