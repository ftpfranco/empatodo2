<?php

namespace App\Http\Controllers;

use App\Proveedor;
use App\TipoIdentificacion;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //'id','nombre','email','tipo_identificacion_id','nro_dni','telefono',
        // 'localidad','calle','nro_calle','piso','eliminado','tiene_ccorriente','creator_id', 
        // 'created_at','updated_at'
        $tipoidentificacion = TipoIdentificacion::select("id", "tipo_identificacion")->where("eliminado", false)->pluck("tipo_identificacion", "id");
        $proveedores = Proveedor::select('id', 'nombre', 'email', 'tipo_identificacion_id', 'nro_dni', 'telefono', 'localidad', 'direccion', 'habilitado')
            ->where('eliminado', false)
            ->where('id', "<>",1)
            ->orderby("id","desc")
            ->paginate(15);

        return view("proveedores.index", compact("proveedores", "tipoidentificacion"));
        // return response()->json(["status" => "success", "proveedores" => $proveedores]);



    }





    public function filtro(Request $request)
    {

        $proveedores = Proveedor::select('id', 'nombre', 'email', 'tipo_identificacion_id', 'nro_dni', 'telefono', 'localidad', 'direccion', 'habilitado', 'eliminado')
            ->where('eliminado', false)
            ->paginate(15);

        return response()->json(view("proveedores.index_data", compact("proveedores"))->render());
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
            'nombre' => 'required|string|max:500',
            'email' => 'nullable|email',
            'identificacion_id' => 'nullable|numeric',
            'nroidentificacion' => 'nullable|numeric',
            'telefono' => 'nullable|numeric',
            'direccion' => 'nullable|string',
            'localidad' => 'nullable|string',
            // 'habilitado' => 'nullable|string'
            // 'nota_adicional'=>"string|max:5000"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $data = array();
        $data['nombre'] = request()->nombre;
        $data['email'] = request()->email;
        $data['tipo_identificacion_id'] = request()->identificacion_id?request()->identificacion_id:1;
        $data['nro_dni'] = request()->nroidentificacion;
        $data['telefono'] = request()->telefono;
        $data['direccion'] = request()->direccion;
        $data['localidad'] = request()->localidad;
        // $data['habilitado'] = request()->habilitado;

        $proveedor = Proveedor::create($data);

        $data["id"] = $proveedor->id;
        if(!$proveedor) return response()->json(["status" => "error", "message" => "Guardado!"]);
        return response()->json(["status" => "success", "message" => "Guardado!","data"=>$data]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProveedorController  $proveedorController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        // $creator_id = auth()->user()->creator_id;
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|string',
            'email' => 'nullable|email',
            'identificacion_id' => 'nullable|numeric',
            'dni' => 'nullable|string',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
            'localidad' => 'nullable|string',
            // 'habilitado' => 'nullable|string'
            // 'nota_adicional'=>"string|max:5000"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $nombre = request()->nombre ? request()->nombre : null;
        $email = request()->email ? request()->email : null;
        $tipoidentificacion_id = request()->identificacion_id ? request()->identificacion_id : 1;
        $dni = request()->dni ? request()->dni : null;
        $telefono = request()->telefono ? request()->telefono : null;
        $localidad = request()->localidad ? request()->localidad : null;
        $direccion = request()->direccion ? request()->direccion : null;
        // $habilitado = request()->habilitado;


        $data = array(
            "nombre" => $nombre,
            "email" => $email,
            "tipo_identificacion_id" => $tipoidentificacion_id,
            "nro_dni" => $dni,
            "telefono" => $telefono,
            "localidad" => $localidad,
            "direccion" => $direccion,
            // "habilitado" => $habilitado
        );
        // 'id','nombre','email','tipo_identificacion_id','nro_dni','telefono',
        // 'localidad','direccion','eliminado', 
        // 'created_at','updated_at'
        $proveedor = Proveedor::where('id', $id)
            ->where('eliminado', false)
            ->update($data);

        $data["id"] = $id;
        if ($proveedor) {
            return response()->json(["status" => "success", "message" => "Editato correctamente!","data"=>$data]);
        }
        return response()->json(["status" => "error", "message" => "Error al editar!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProveedorController  $proveedorController
     * @return \Illuminate\Http\Response
     */
    public function destroy($proveedor)
    {
        //
        $s = Proveedor::where('id', $proveedor)->where("eliminado", false)->update([
            "eliminado" => true
        ]);

        if ($s) {
            return response()->json([
                "status" => "success",
                "message" => "Eliminado!"
            ]);
        }

        return response()->json(["status" => "error", "message" => "Error !"]);
    }
}
