<?php

namespace App\Http\Controllers;

use App\User;
use App\Turno;
use Illuminate\Http\Request;
// use Mews\Purifier\Facades\Purifier;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // 'id','nombre',"nombre_fantasia", 'email', 'password',"tipo_identificacion_id","nro_dni","telefono","localidad","calle","nro_calle","piso","es_empleado"

        // $tipoidentificacion = TipoIdentificacion::select("id", "tipo_identificacion")->where("eliminado", false)->pluck("tipo_identificacion", "id");
        // $empleados = User::select('users.id', 'users.nombre', 'users.email', "users.nro_dni", "users.telefono", "users.localidad","users.habilitado","users.horarios","turnos.time1_start","turnos.time1_end","turnos.time2_start","turnos.time2_end")
        // ->leftjoin("turnos","turnos.user_id","=","users.id")
        // ->where([
        //     ["users.es_empleado", true],
        //     ["users.eliminado", false,]
        // ])
        // ->orwhere("turnos.eliminado",false)
        // ->orderby("users.id","desc")->paginate(15);

        $empleados = User::select('id', 'nombre', 'email', "nro_dni", "telefono","direccion", "localidad","habilitado","horarios" )
        ->where( "es_empleado", true)
        ->where( "eliminado", false)
        ->orderby("id","desc")->paginate(15);


        // dd($empleados->all());
        // return view("empleados.index", compact("empleados", "tipoidentificacion"));
        return view("empleados.index", compact("empleados"));
    }




    public function filtro(Request $request)
    {

        if(!$request->ajax()) return redirect()->url("empleados");
        $empleados = User::select('id', 'nombre', 'email', "nro_dni", "telefono","direccion", "localidad","habilitado","horarios" )
        ->where( "es_empleado", true)
        ->where( "eliminado", false)
        ->orderby("id","desc")->paginate(15);
        return response()->json(view("empleados.index_data", compact("empleados"))->render());
    }






    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 'id','nombre','email','tipo_identificacion_id','nro_dni','telefono',
        // 'localidad','calle','nro_calle','piso','eliminado','tiene_ccorriente','creator_id',
        // 'eliminado', 'created_at','updated_at


        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|string|max:500',
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'nullable|string|max:200',
            'identificacion_id' => 'nullable|numeric|max:7',
            'nroidentificacion' => 'nullable|numeric|max:7',
            'telefono' => 'nullable|numeric|max:200',
            'direccion' => 'nullable|string|max:200',
            'localidad' => 'nullable|string|max:200',
            'time1_start' => 'nullable|date_format:H:i',
            'time1_end' => 'nullable|date_format:H:i|after:time1_start',
            'time2_start' => 'nullable|date_format:H:i',
            'time2_end' => 'nullable|date_format:H:i|after:time2_start',
            'habilitado' => 'nullable|string'
            // 'nota_adicional'=>"string|max:5000"
        ],[
            "nombre.required" => "Debes ingresar un numero de usuario",
            "email.unique" => "El mail ingresado ya fue utilizado!",
            "time1_end.after" => "La hora de fin del Turno mañana no debe ser igual a la hora de inicio del Turno mañana",
            "time2_end.after" => "La hora de fin del Turno tarde no debe ser igual a la hora de inicio del Turno tarde",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $time1_start = !empty($request->time1_start) ? $request->time1_start: null;
        $time1_end = !empty($request->time1_end) ? $request->time1_end: null;
        $time2_start = !empty($request->time2_start) ? $request->time2_start: null;
        $time2_end = !empty($request->time2_end) ? $request->time2_end: null;
        
        if(($time1_start == null && $time1_end== null ) && ($time2_start==null && $time2_end==null)){
            return response()->json(["status" => "error", "message" => "Debes agregar un turno laboral" ]);
        }

        $data = array();
        $turno = array();
        $creator_id = auth()->user()->id; 
        $nroidentificacion = trim(request()->nroidentificacion) &&  !empty(request()->nroidentificacion) ? trim(request()->nroidentificacion): null;
        $nombre = trim(request()->nombre) &&  !empty(request()->nombre) ? trim(request()->nombre): null;
        $telefono = trim(request()->telefono) &&  !empty(request()->telefono) ? trim(request()->telefono): null;
        $direccion = trim(request()->direccion) &&  !empty(request()->direccion) ? trim(request()->direccion): null;
        $localidad = trim(request()->localidad) &&  !empty(request()->localidad) ? trim(request()->localidad): null;

        if($nombre) {
            // $nombre =  Purifier::clean($nombre);
            // $nombre = str_replace("&lt;?","",$nombre);
            $nombre = str_replace("'","",$nombre);
            $nombre = trim($nombre);
        }
        if($nombre) {
            // $nombre =  Purifier::clean($nombre);
            // $nombre = str_replace("&lt;?","",$nombre);
            $nombre = str_replace("'","",$nombre);
            $nombre = trim($nombre);
        }
        if($telefono) {
            // $telefono =  Purifier::clean($telefono);
            // $telefono = str_replace("&lt;?","",$telefono);
            $telefono = str_replace("'","",$telefono);
            $telefono = trim($telefono);
        }
        if($direccion) {
            // $direccion =  Purifier::clean($direccion);
            // $direccion = str_replace("&lt;?","",$direccion);
            $direccion = str_replace("'","",$direccion);
            $direccion = trim($direccion);
        }
        if($localidad) {
            // $localidad =  Purifier::clean($localidad);
            // $localidad = str_replace("&lt;?","",$localidad);
            $localidad = str_replace("'","",$localidad);
            $localidad = trim($localidad);
        }

        $data['nombre'] = $nombre;
        $data['email'] = request()->email;
        $data['tipo_identificacion_id'] = request()->identificacion_id ? request()->identificacion_id : 1;
        $data['nro_dni'] = $nroidentificacion;
        $data['telefono'] = $telefono;
        $data['direccion'] = $direccion;
        $data['localidad'] = $localidad;
        $data['habilitado'] = request()->habilitado;
        $data['email_verified_at'] = now();
        $data['password'] = bcrypt(request()->password);  
        $data['remember_token'] = \Str::random(10);

        $horarios = "";
        $bandera=false;
    
        if($time1_start && $time1_end){
            $horarios.= $time1_start." a ".$time1_end." hs";
            $bandera = true;
            $turno["time1_start"] = $time1_start;
            $turno["time1_end"] = $time1_end;
        }
        if($time2_start && $time2_end){
            if($bandera){
                $horarios.= " y ";
            }
            $horarios.=  $time2_start." a ".$time2_end." hs";
            $turno["time2_start"] = $time2_start;
            $turno["time2_end"] = $time2_end;
            $bandera = true;
        }
        $data["horarios"] = $horarios;

        $empleado = User::create($data);
        $data["id"] = $empleado->id;
        unset($data['email_verified_at'] );
        unset($data['password']);
        unset( $data['remember_token'] );
        $empleado->assignRole('vendedor');


        // 'id','time1_start' ,"time1_end","time2_start","time2_end","user_id",'creator_id','eliminado','created_at','updated_at'
        if($bandera){
            Turno::create([
                "time1_start" => $time1_start,
                "time1_end" => $time1_end,
                "time2_start" => $time2_start,
                "time2_end" => $time2_end,
                "user_id" => $data["id"],
                "creator_id" => $creator_id,
            ]);
            $data["time1_start"] = $time1_start;
            $data["time1_end"] = $time1_end;
            $data["time2_start"] = $time2_start;
            $data["time2_end"] = $time2_end;
        }


        if (!$empleado) return response()->json(["status" => "error", "message" => "Error, no se guardaron los datos!"]);

        return response()->json(["status" => "success", "message" => "Guardado!", "data" => $data]);
    }

 
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClienteController  $clienteController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|string|max:500',
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'nullable|string|max:200',
            // 'identificacion_id' => 'nullable|numeric|max:7',
            'dni' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:200',
            'direccion' => 'nullable|string|max:200',
            'localidad' => 'nullable|string|max:200',
            'habilitado' => 'nullable|string',
            'time1_start' => 'nullable|date_format:H:i',
            'time1_end' => 'nullable|date_format:H:i',
            'time2_start' => 'nullable|date_format:H:i',
            'time2_end' => 'nullable|date_format:H:i',
            // 'nota_adicional'=>"string|max:5000"
        ], [
            "nombre.required" => "Debes ingresar un nombre de usuario",
            "email.unique" => "El mail ingresado ya esta en uso",
            "time1_end.after" => "La hora de fin del Turno mañana no debe ser igual a la hora de inicio del Turno mañana",
            "time2_end.after" => "La hora de fin del Turno tarde no debe ser igual a la hora de inicio del Turno tarde",
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => $validator->errors()->all()]);

            // return response()->json(['errors' => $validator->errors()->all()]);
        }

        $time1_start = !empty($request->time1_start) ? $request->time1_start: null;
        $time1_end = !empty($request->time1_end) ? $request->time1_end: null;
        $time2_start = !empty($request->time2_start) ? $request->time2_start: null;
        $time2_end = !empty($request->time2_end) ? $request->time2_end: null;
      
        $turno = array();
        $creator_id = auth()->user()->id; 
         
        // $nombre = request()->nombre ? request()->nombre : null;
        $email = !empty(trim(request()->email ))? request()->email : null;
        $password = request()->password ? request()->password : null;
        // $tipoidentificacion_id = request()->identificacion_id ? request()->identificacion_id : 1;
        // $dni = request()->dni ? request()->dni : null;
        // $telefono = request()->telefono ? request()->telefono : null;
        // $localidad = request()->localidad ? request()->localidad : null;
        // $direccion = request()->direccion ? request()->direccion : null;
        $habilitado = (request()->habilitado === "true" || request()->habilitado === true )? true : false;
        
        $dni = trim(request()->dni) &&  !empty(request()->dni) ? trim(request()->dni): null;
        $nombre = trim(request()->nombre) &&  !empty(request()->nombre) ? trim(request()->nombre): null;
        $telefono = trim(request()->telefono) &&  !empty(request()->telefono) ? trim(request()->telefono): null;
        $direccion = trim(request()->direccion) &&  !empty(request()->direccion) ? trim(request()->direccion): null;
        $localidad = trim(request()->localidad) &&  !empty(request()->localidad) ? trim(request()->localidad): null;

        if($nombre) {
            // $nombre =  Purifier::clean($nombre);
            // $nombre = str_replace("&lt;?","",$nombre);
            $nombre = str_replace("'","",$nombre);
            $nombre = trim($nombre);
        }
        if($nombre) {
            // $nombre =  Purifier::clean($nombre);
            // $nombre = str_replace("&lt;?","",$nombre);
            $nombre = str_replace("'","",$nombre);
            $nombre = trim($nombre);
        }
        if($telefono) {
            // $telefono =  Purifier::clean($telefono);
            // $telefono = str_replace("&lt;?","",$telefono);
            $telefono = str_replace("'","",$telefono);
            $telefono = trim($telefono);
        }
        if($direccion) {
            // $direccion =  Purifier::clean($direccion);
            // $direccion = str_replace("&lt;?","",$direccion);
            $direccion = str_replace("'","",$direccion);
            $direccion = trim($direccion);
        }
        if($localidad) {
            // $localidad =  Purifier::clean($localidad);
            // $localidad = str_replace("&lt;?","",$localidad);
            $localidad = str_replace("'","",$localidad);
            $localidad = trim($localidad);
        }
        
        $data = array(
            "nombre" => $nombre,
            "email" => $email,
            "password" => bcrypt($password),
            // "tipo_identificacion_id" => $tipoidentificacion_id,
            "nro_dni" => $dni,
            "telefono" => $telefono,
            "localidad" => $localidad,
            "direccion" => $direccion,
            "habilitado" => $habilitado
        );
        if($password ==null){
            unset($data["password"]);
        }
        if($email ==null){
            unset($data["email"]);
        }

        $horarios = "";
        $bandera=false;
    
        if($time1_start && $time1_end){
            $horarios.= $time1_start." a ".$time1_end." hs";
            $bandera = true;
            $turno["time1_start"] = $time1_start;
            $turno["time1_end"] = $time1_end;
        }
        if($time2_start && $time2_end){
            if($bandera){
                $horarios.= " y ";
            }
            $horarios.=  $time2_start." a ".$time2_end." hs";
            $turno["time2_start"] = $time2_start;
            $turno["time2_end"] = $time2_end;
            $bandera = true;
        }
        $data["horarios"] = $horarios;

        $empleado = User::where('id', $id)
            ->where('eliminado', false)
            ->update($data);
       

        // 'id','time1_start' ,"time1_end","time2_start","time2_end","user_id",'creator_id','eliminado','created_at','updated_at'
        if($bandera){
            Turno::where("user_id",$id)->update([
                "eliminado" => true,
            ]);
            
            Turno::create([
                "time1_start" => $time1_start,
                "time1_end" => $time1_end,
                "time2_start" => $time2_start,
                "time2_end" => $time2_end,
                "user_id" => $id,
                "creator_id" => $creator_id,
            ]);
            $data["time1_start"] = $time1_start;
            $data["time1_end"] = $time1_end;
            $data["time2_start"] = $time2_start;
            $data["time2_end"] = $time2_end;

        }

        $data["id"] = $id;
        unset($data["password"]);
        
        if ($empleado) {
            return response()->json(["status" => "success", "message" => "Editado !", "data" => $data]);
        }
        return response()->json(["status" => "error", "message" => "Error al editar!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClienteController  $clienteController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $s = User::where('id', $id)->where("eliminado", false)->update([
            "eliminado" => true,
            'habilitado' =>false
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
