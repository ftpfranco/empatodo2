<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class TasaIva extends Model
{
    //
    use HasApiTokens ,HasRoles;

    protected $table= "tasa_iva";
    protected $fillable = [
        'id','tasa_iva', 'created_at','updated_at'
    ];


}
