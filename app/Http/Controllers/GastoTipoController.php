<?php

namespace App\Http\Controllers;

use App\GastoTipo;
use Illuminate\Http\Request;
// use Mews\Purifier\Facades\Purifier;

class GastoTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $gastostipos = GastoTipo::select('id', 'gastotipo' )
            ->where('eliminado', false)
            ->orderby("id","desc")
            ->paginate(15);

        return view("gastostipo.index", compact("gastostipos"));

    }



    public function editar(Request $request, $id)
    {
        //
        $validator = \Validator::make($request->all(), [
            'tipogasto' => 'required|string|max:100',
        ]);

        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $user_id = auth()->user()->id;
        $item = request()->tipogasto;

        if($item){
            // $item =  Purifier::clean($item);
            // $item = str_replace("&lt","",$item);
            // $item = str_replace("?","",$item);
            // $item = str_replace("\\","",$item);
            $item = str_replace("--","",$item);
            $item = str_replace("'","",$item);
            $item = trim($item);
        }

        $d = GastoTipo::where("id", $id)->update([
            'gastotipo' => $item,
            "creator_id" => $user_id
        ]);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Editado!"]);
        }

        return response()->json(["status" => "error", "message" => "Error al editar"]);

    }





    public function eliminar(Request $request, $id)
    {
        //

        $d = GastoTipo::where("id", $id)->where("eliminado",false)->update([
            'eliminado' => true,
        ]);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Eliminado!"]);
        }
        return response()->json(["status" => "error", "message" => "No se pudo eliminar"]);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'tipogasto' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user_id = auth()->user()->id;
        $tipogasto = request()->tipogasto ? request()->tipogasto : null;

        if($tipogasto){
            // $tipogasto =  Purifier::clean($tipogasto);
            // $tipogasto = str_replace("&lt","",$tipogasto);
            // $tipogasto = str_replace("?","",$tipogasto);
            // $tipogasto = str_replace("\\","",$tipogasto);
            $tipogasto = str_replace("--","",$tipogasto);
            $tipogasto = str_replace("'","",$tipogasto);
            $tipogasto = trim($tipogasto);
        }

        $d = GastoTipo::create([
            'gastotipo' => $tipogasto,
            "creator_id" => $user_id
        ]);

        $data["id"] = $d->id;
        $data["tipogasto"] = $tipogasto;
 
        
        if ($d) {
            return response()->json(["status" => "success", "message" => "Guardado!","data"=>$data]);
        }
        return response()->json(["status" => "error", "message" => "Error al guardar "]);
    }

    
    
    
}
