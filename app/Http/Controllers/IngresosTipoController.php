<?php

namespace App\Http\Controllers;

use App\IngresoTipo;
use Illuminate\Http\Request;

class IngresosTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ingresostipos = IngresoTipo::select('id', 'ingresotipo')
            ->where('eliminado', false)
            ->orderby("id","desc")
            ->paginate(15);

        return view("ingresostipos.index", compact("ingresostipos"));
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
            'ingresotipo' => 'required|string|max:100',
        ],[
            "ingresotipo.required" => "La Categoria de Ingreso no es válido",
            "ingresotipo.max" => "La Categoria de Ingreso no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $ingresotipo = request()->ingresotipo;
        $d = IngresoTipo::create([
            'ingresotipo' => $ingresotipo,
        ]);

        $data["id"] = $d->id;
        $data["ingresotipo"]=  $ingresotipo;

        if ($d) {
            return response()->json(["status" => "success", "message" => "Guardado!","data"=>$data]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);
    }

    


    public function editar(Request $request,$id)
    {
        //
        $validator = \Validator::make($request->all(), [
            'ingresotipo' => 'required|string|max:100',
        ],[
            "ingresotipo.required" => "La Categoria de Ingreso no es válido",
            "ingresotipo.max" => "La Categoria de Ingreso no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $ingresotipo = request()->ingresotipo;
 
        $d =  IngresoTipo::where("id",$id)->where("eliminado",false)->update(["ingresotipo"=>$ingresotipo]);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Editado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);
    }

    



    public function eliminar(Request $request,$id){

        $validator = \Validator::make($request->all(), [
            'ingresotipo' => 'required|string|max:100',
        ],[
            "ingresotipo.required" => "La Categoria de Ingreso no es válido",
            "ingresotipo.max" => "La Categoria de Ingreso no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        // si no ex ajax redireccionar a home
        if(!$request->ajax()) return redirect()->route("home");

        $d =  IngresoTipo::where("id",$id)->where("eliminado",false)->update(["eliminado"=>true]);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Eliminado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);
    }
    
    
}
