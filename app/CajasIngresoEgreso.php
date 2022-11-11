<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;


class CajasIngresoEgreso extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;

    protected $table= "cajas_mov";
    protected $fillable = [
        'id','cajadetalle_id','user_id', 'es_ingreso','monto','comentario','eliminado','created_at','updated_at'
    ];

    
}

