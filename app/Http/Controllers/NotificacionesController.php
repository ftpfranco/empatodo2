<?php

namespace App\Http\Controllers;

use App\Categorias;
use App\Notificacion;
use App\Subcategoria;
use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $notificaciones =  Notificacion::select("notificaciones.id","notificaciones.descripcion","notificaciones.articulo_id","articulos.articulo")
        // ->leftjoin("articulos","articulos.id","=","notificaciones.articulo_id")
        // ->where("notificaciones.eliminado",false)
        // ->where("articulos.eliminado",false)
        // ->orderby("id","desc")->paginate(10);

        $notificaciones =  Notificacion::select("id", "descripcion", "articulo_id","created_at")
            ->where("eliminado", false)
            ->orderby("id", "desc")->paginate(15);

        if ($request->ajax()) {
            return response()->json(["status" => "success", "data"=>$notificaciones]);
        }

        return view("notificaciones.index", compact("notificaciones"));

        // return response()->json(["status" => "success", "categorias" => $categorias]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $id = request()->id;
        $creator_id = auth()->user()->creator_id;

        $s = Notificacion::where('id', $id)->where('eliminado', false)->update([
            "eliminado" => true
        ]);

        if ($s) {
            return response()->json([
                "status" => "success",
                "message" => "Eliminado!"
            ]);
        }

        return response()->json(["status" => "error", "message" => "Error al eliminar!"]);
    }
}
