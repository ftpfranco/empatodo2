<?php

namespace App\Http\Controllers;

use App\Categorias;
use App\Subcategoria;
use Illuminate\Http\Request;
// use Mews\Purifier\Facades\Purifier;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categorias = array();
        $categorias = Categorias::select('id', 'categoria', 'created_at', 'updated_at')->where('eliminado', false)->orderby("id","desc")->get();
        return view("categorias.index", compact("categorias"));
        // return response()->json(["status" => "success", "categorias" => $categorias]);
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
            'categoria' => 'required|string|max:500',
            // 'nota_adicional'=>"string|max:5000"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user_id = auth()->user()->id;
        $categoria = trim(request()->categoria) && !empty(request()->categoria) ? trim(request()->categoria): null;

        if($categoria){
            // $categoria =  Purifier::clean($categoria);
            // $categoria = str_replace("&lt","",$categoria);
            // $categoria = str_replace("?","",$categoria);
            // $categoria = str_replace("\\","",$categoria);
            $categoria = str_replace("--","",$categoria);
            $categoria = str_replace("'","",$categoria);
            $categoria = trim($categoria);
        }


        $d = Categorias::create([
            'categoria' => $categoria,
            "user_id" => $user_id,
        ]);

        $data = array();
        $data["categoria"] = $categoria ;
        $data["id"] = $d->id;

        if ($d) {
            return response()->json(["status" => "success", "message" => "Guardado!","data"=>$data]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);
    }





    public function edit(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'categoria' => 'required|string|max:100',
            'id' => 'numeric'
            // 'nota_adicional'=>"string|max:5000"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        
        $user_id = auth()->user()->id;
        $categoria = trim(request()->categoria) && !empty(request()->categoria) ? trim(request()->categoria): null;
        $id = request()->id;

        if($categoria){
            // $categoria =  Purifier::clean($categoria);
            // $categoria = str_replace("&lt","",$categoria);
            // $categoria = str_replace("?","",$categoria);
            // $categoria = str_replace("\\","",$categoria);
            $categoria = str_replace("--","",$categoria);
            $categoria = str_replace("'","",$categoria);
            $categoria = trim($categoria);
        }


        $d = Categorias::where('id',$id)->update([
            'categoria' => $categoria,
        ]);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Editado!"]);
        }
        return response()->json(["status" => "error", "message" => "Error"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function show($categoria)
    {
        //
        $creator_id = auth()->user()->creator_id;
        $categorias = array();
        if ($creator_id) {
            $categorias = Categorias::select('id', 'categoria', 'created_at', 'updated_at')->where("id", $categoria)->where("eliminado", false)->where("creator_id", $creator_id)->first();
        }
        return response()->json(["status" => "success", "categoria" => $categorias]);
    }


    public function subcategorias($categoria)
    {
        //
        $creator_id = auth()->user()->creator_id;
        $subcategorias = array();
        if ($creator_id) {
            $subcategorias = Subcategoria::select('id', 'subcategoria', 'created_at', 'updated_at')
                ->where("categoria_id", $categoria)
                ->where("eliminado", false)
                ->where("creator_id", $creator_id)
                ->get();
        }
        return response()->json(["status" => "success", "subcategorias" => $subcategorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $categoria)
    {
        //
        $creator_id = auth()->user()->creator_id;
        $categorias = $request->validate([
            'categoria' => 'required|string|max:100',
        ]);

        $categorias = request(['categoria']);

        $s = Categorias::where('id', $categoria)->where('creator_id', $creator_id)->where('eliminado', false)->update([
            'categoria' => $categorias['categoria'],
        ]);

        if ($s) {
            return response()->json(["status" => "success", "message" => "Guardado!"]);
        }

        return response()->json(["status" => "error", "message" => "Categoria no existe!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        // $creator_id = auth()->user()->creator_id;
        $s = Categorias::where('id', $id)->where('eliminado', false)->update([
            "eliminado" => true
        ]);

        if ($s) {
            return response()->json([
                "status" => "success",
                "message" => "Eliminado!"
            ]);
        }

        return response()->json(["status" => "error", "message" => "Categoria no existe!"]);
    }
}
