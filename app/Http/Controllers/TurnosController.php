<?php

namespace App\Http\Controllers;

use App\Turno;
use App\User;
use Illuminate\Http\Request;

class TurnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) {
            return abort(404);
        }
 
        $id = trim($request->empleado_id );
        $user_id = isset($id ) && !empty($id ) ? $id : null;

        if($user_id == null) {
            return response()->json(["status" => "error", "message" => "Usuario existe" ]);
        }

        $user = User::where("id",$user_id)->where("eliminado",false)->first();
       
        if(!$user){
            return response()->json(["status" => "error", "message" => "Usuario existe" ]);
        }

        $turno = Turno::select( \DB::raw("to_char(time1_start,'HH24:MI') as time1_start"),\DB::raw("to_char(time1_end,'HH24:MI') as time1_end"), \DB::raw("to_char(time2_start,'HH24:MI') as time2_start"), \DB::raw("to_char(time2_end,'HH24:MI') as time2_end"))->where("user_id",$user_id)->where("eliminado",false)->first();
        
        return response()->json(["status" => "success", "data" => $turno ]);

    }

     
}
