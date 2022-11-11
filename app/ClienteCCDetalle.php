<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ClienteCCDetalle extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table="cliente_cc_detalle";
    protected $fillable = [
        'id','cliente_id','venta_id','monto',"fecha", 'eliminado','user_id','creator_id','created_at','updated_at'
    ];
}
