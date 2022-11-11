<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $marcas = Marca::select('id', 'marca', 'created_at', 'updated_at')->where('eliminado', false)->paginate(15);
        return view("marcas.index", compact("marcas"));
        // return response()->json(["status" => "success", "marca" => $marca]);
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
            'marca' => 'required|string|max:500',
            // 'nota_adicional'=>"string|max:5000"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $item = request(['marca']);
        $d = Marca::create([
            'marca' => $item['marca'],
        ]);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Guardado correctamente!"]);
        }
        return response()->json(["status" => "error", "message" => "Error al guardar"]);
    }




    public function edit(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'marca' => 'required|string|max:500',
            'id' => 'numeric'
            // 'nota_adicional'=>"string|max:5000"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $marca = request()->marca ;
        $id = request()->id;

        
        $d = Marca::where('id', $id) //->where('creator_id', $creator_id)
            ->where('eliminado', false)
            ->update([
                'marca' => $marca ,
            ]);


        if ($d) {
            return response()->json(["status" => "success", "message" => "Editado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error al editar"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($marca)
    {
        //

        $creator_id = auth()->user()->creator_id;
        $marca = Marca::select('id', 'marca', 'created_at', 'updated_at')->where('id', $marca)->where('creator_id', $creator_id)
            ->where('eliminado', false)
            ->first();
            
        if ($marca) {
            return response()->json(["status" => "success", "marca" => $marca]);
        }
        return response()->json(["status" => "error", "message" => "Marca no existe."]);
    }

 

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $creator_id = auth()->user()->creator_id;
        $s = Marca::where('id', $id)
            ->where('eliminado', false)
            ->update([
                'eliminado' => true,
            ]);

        if ($s) {
            return response()->json(["status" => "success", "message" => "Eliminado!"]);
        }

        return response()->json(["status" => "error", "message" => "Error al eliminar!"]);
    }
}
