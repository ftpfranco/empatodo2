<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    //
    // use HasApiTokens ,
    use HasRoles;
    protected $table="reportes";
    protected $fillable = [
        'id', "cantidad_compras","cantidad_ventas","cantidad_ingresos","cantidad_egresos","monto_compras","monto_ventas","monto_ingresos","monto_egresos","mes","anio",'created_at','updated_at'
    ];
}


 