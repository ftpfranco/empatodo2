<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    //
    // use HasApiTokens ,HasRoles;

    protected $table= "turnos";
    // t1_inicio = turno1 inicio, turno1 fin
    protected $fillable = [
        'id','time1_start' ,"time1_end","time2_start","time2_end","user_id",'creator_id','eliminado','created_at','updated_at'
    ];

}
