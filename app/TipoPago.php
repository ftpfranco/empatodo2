<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;

    protected $table= "tipopago";
    protected $fillable = [
        'id','tipo_pago','eliminado','created_at','updated_at'
    ];
}
