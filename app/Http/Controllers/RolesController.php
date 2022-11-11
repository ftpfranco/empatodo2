<?php

namespace App\Http\Controllers;

use App\Permisos;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $roles = Role::select('id','name')->get();
        if(request()->ajax()){
            return response()->json(["status" => "success",  "data" => $roles]);
        }
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        
        if($request->ajax())  return response()->json(["status" => "error", "message" => "Error!"]);


        $permisos_categorias = Permission::select("id","name","description")->where("name","ilike","%.categorias")->get();
        $permisos_articulos = Permission::select("id","name","description")->where("name","ilike","%.articulos")->get();
        $permisos_clientes = Permission::select("id","name","description")->where("name","ilike","%.clientes")->get();
        $permisos_proveedores = Permission::select("id","name","description")->where("name","ilike","%.proveedores")->get();
        $permisos_compras = Permission::select("id","name","description")->where("name","ilike","%.compras")->get();
        $permisos_ventas = Permission::select("id","name","description")->where("name","ilike","%.ventas")->get();
        $permisos_caneros = Permission::select("id","name","description")->where("name","ilike","%.caneros.caneros")->get();
        $permisos_items_caneros = Permission::select("id","name","description")->where("name","ilike","%.items.caneros")->get();
        $permisos_compra_caneros = Permission::select("id","name","description")->where("name","ilike","%.compra.caneros")->get();
        $permisos_remitos_caneros = Permission::select("id","name","description")->where("name","ilike","%.remitos.caneros")->get();
        $permisos_cheques = Permission::select("id","name","description")->where("name","ilike","%.cheques")->get();
        $permisos_roles = Permission::select("id","name","description")->where("name","ilike","%.roles")->get();
        $permisos_usuarios = Permission::select("id","name","description")->where("name","ilike","%.usuarios")->get();
        $permisos_inicio = Permission::select("id","name","description")->where("name","ilike","%.inicio")->get();
        $permisos_configuracion = Permission::select("id","name","description")->where("name","ilike","%.configuraciones")->get();
        $permisos_informes = Permission::select("id","name","description")->where("name","ilike","%.informe")->get();

        
        return view('roles.nuevo',compact('role',"permisos_clientes","permisos_usuarios","permisos_roles","permisos_caneros","permisos_items_caneros","permisos_compra_caneros","permisos_remitos_caneros","permisos_cheques",
                "permisos_proveedores","permisos_compras","permisos_ventas","permisos_articulos","permisos_categorias","permisos_configuracion","permisos_inicio","permisos_informes"));

    }


    public function edit(Request $request, $id){

        if($request->ajax())  return response()->json(["status" => "error", "message" => "Error!"]);

        // $validator = \Validator::make($request->all(), [
        //     'id' => 'required|numeric',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()->all()]);
        // }

        $permisos =  Permission::select("id","name","description")->orderby("name","asc")->get();
        $role  = Role::select("id","name")->where("id",$id)->first();
        $mis_permisos = $role->permissions->pluck('name',"id");
        // $role->permissions->count();

        return view("roles.edit",compact("role","permisos","mis_permisos"));

        
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
            'rol' => 'required|string',
            'permisos' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $role_name  = trim(request()->rol) !==null ? trim(request()->rol) : null;
        $permisos = request()->permisos !==null ? request()->permisos : null;

        $permissions =  Permission::whereIn('id',$permisos)->get();
        $role = Role::create([
            'name' => $role_name,
        ]);

        // $role->givePermissionTo(Permission::whereIn('id',$permisos));
        $role->syncPermissions($permissions);
       
        
        if($role){
            // $content= ['id'=>$cat->id,'name'=>$role_name];
            return response()->json(["status" => "success", "message" => "Guardado!" ]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);


    }
 
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric',
            "rol" => "required|string",
            'permisos' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $id = request()->id ? request()->id  : null;
        $role = trim(request()->rol) !== null ? trim(request()->rol): null ;
        $permisos = request()->permisos !==null ? request()->permisos : null;


        $role = Role::where('id',$id)->update(["name"=>$role]);
        $role = Role::where("id",$id)->first();
        $permissions =  Permission::whereIn('id',$permisos)->get();
        $role->syncPermissions($permissions);

        if($role){
            return response()->json(["status" => "success", "message" => "Guardado!"  ]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric ',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $id = request()->id ? request()->id  : null;

        $role = Role::where('id',$id)->delete();
        if($role){
            return response()->json(["status" => "success", "message" => "Eliminado!" ]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);

    }
}
