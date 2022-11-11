<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ClienteCCPago extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table="cliente_cc_pago";
    protected $fillable = [
        'id','cliente_id','tipopago_id',"fecha",'monto', "monto_anterior",'eliminado','user_id','creator_id','created_at','updated_at'
    ];
}
