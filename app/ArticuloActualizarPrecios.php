<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ArticuloActualizarPrecios extends Model
{
    //
    use HasApiTokens ,HasRoles;

    protected $table= "articulo_actualizar_precios";
    protected $fillable = [
        'id','tipo_precio','accion','tipo_monto','marcas','categorias','monto','creator_id',  'eliminado','created_at','updated_at'
    ];
}

