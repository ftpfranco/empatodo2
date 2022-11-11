<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class VentasEstadoEnvio extends Model
{
    //
    use HasRoles;
    protected $table="ventas_estadoenvio";
    protected $fillable = [
        'id','nombre','eliminado','created_at','updated_at'
    ];

    
}
