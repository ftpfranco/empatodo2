<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ProveedorCCPago extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table="proveedor_cc_pago";
    protected $fillable = [
        'id','proveedor_id','tipopago_id',"fecha",'monto',"monto_anterior", 'eliminado','user_id','creator_id','created_at','updated_at'
    ];
}
