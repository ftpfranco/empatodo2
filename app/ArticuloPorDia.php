<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class ArticuloPorDia extends Model
{
    //
    //  use HasApiTokens, 
    use HasRoles;

    protected $table = "articulos_vendidos_por_dia";
    protected $fillable = [
        'id', 'articulo_id', 'articulo', "cantidad",'anio', 'mes', 'dia',  't1',"t2", 'creator_id',
        'eliminado', 'created_at', 'updated_at'
    ];
}
