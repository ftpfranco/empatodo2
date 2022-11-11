<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    //
    //  use HasApiTokens, 
    use HasRoles;

    protected $table = "articulos";
    protected $fillable = [
        'id', 'articulo', 'codigo', "nombre_corto",'codigo_barras', 'stock', 'stock_minimo',  'precio_compra','precio_venta','precio_neto_venta',
        'marca_id','categoria_id', 'subcategoria_id', 'tasa_iva_id', 'precio_id', 'creator_id',
        'habilitado', 'eliminado', 'created_at', 'updated_at'
    ];
}
