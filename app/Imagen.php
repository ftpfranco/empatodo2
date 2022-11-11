<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    //
    use HasApiTokens, HasRoles;
    protected $table = "imagens";
    protected $fillable = [
        'id', 'imagen', 'original','thumbnails','eliminado','articulo_id','creator_id', 'created_at', 'updated_at'
    ];
}

