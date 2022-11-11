<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ProveedorCCDetalle extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table="proveedor_cc_detalle";
    protected $fillable = [
        'id','proveedor_id','compra_id','monto',"fecha", 'eliminado','user_id','creator_id','created_at','updated_at'
    ];
}
