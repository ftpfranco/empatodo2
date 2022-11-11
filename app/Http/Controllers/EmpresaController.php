<?php

namespace App\Http\Controllers;

use App\User;
use App\Gasto;
use App\Empresa;
use App\GastoTipo;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
// use Intervention\Image\ImageManagerStatic as Image;


class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 'id','nombre','cuit','email','telefono','whatsapp','provincia','localidad','direccion','creator_id','habilitado','eliminado','created_at','updated_at'

        $user_id =  auth()->user()->id;
        $empresa = Empresa::select('id','nombre','cuit','email','telefono','whatsapp','provincia','localidad','direccion',"path_thumbnail")->where("user_id",$user_id)->first();
        // $empresa = User::select('nombre','cuit','email','telefono','whatsapp','provincia','localidad','direccion')->where("es_empleado",false)->first();
        // dd($empresa);

        if($empresa){
            if(!file_exists($empresa->path_thumbnail)) unset($empresa["path_thumbnail"]);
        }

        return view("empresa.index", compact("empresa"));
    }


    
    public function logoventas(Request $request){

        $user_id = auth()->user()->id;
       
        if(request()->file('logo')){
            $rules=[ 'logo' => 'mimes:jpeg,jpg,bmp,png|max:900000' ];
            request()->validate($rules);
            // $messages = [ 'image' => 'The imagen attribute field is required.' ];
            // $validator = Validator::make(request()->all(), $rules);
            // if ($validator->fails()) {
            //     return response()->json(['data'=>['status'=>'error','content'=>$validator->customMessages]]);
            // }

            $cover = request()->file('logo');
            $extension = $cover->getClientOriginalExtension();
            // $original_filename = $cover->getClientOriginalName();
            // $filename = $cover->getFilename().'.'.$extension;
            $filename = microtime(true).'.'.$extension;
            $path = public_path('/images/original/');
            $cover->move($path,$filename);
            
            
            $thumbnail_path = public_path('/images/thumbnail/');
            $fit = Image::make($path.$filename)->fit(300,300); // 18x21 tamaño para logo ticket
            $fit->save($thumbnail_path.$filename);
            
            $image_thumbnail = "images/thumbnail/$filename";
            $image_original = "images/original/$filename";
            // $user = User::where('id',$user_id)->update([
            //     'img_40' => $image_thumbnail
            // ]);
            Empresa::where("user_id",$user_id)->update([
                "path_image" => $image_original,
                "path_thumbnail" => $image_thumbnail
            ]);
            return response()->json(['status'=>'success',"message"=>"Imagen guardado!",'data'=>url($image_thumbnail)]);
        }
        return response()->json(['status'=>'error',"message"=>"Error al guardar!"]);

    }




    public function logoprofile(Request $request){

        $user_id = auth()->user()->id;
       
        if(request()->file('logo')){
            $rules=[ 'image' => 'mimes:jpeg,jpg,bmp,png|max:900000' ];
            request()->validate($rules);
            // $messages = [ 'image' => 'The imagen attribute field is required.' ];
            // $validator = Validator::make(request()->all(), $rules);
            // if ($validator->fails()) {
            //     return response()->json(['data'=>['status'=>'error','content'=>$validator->customMessages]]);
            // }

            $cover = request()->file('logo');
            $extension = $cover->getClientOriginalExtension();
            // $original_filename = $cover->getClientOriginalName();
            // $filename = $cover->getFilename().'.'.$extension;
            $filename = microtime(true).'.'.$extension;
            $path = public_path('/images/original/');
            $cover->move($path,$filename);
            
            
            $thumbnail_path = public_path('/images/thumbnail/');
            $fit = Image::make($path.$filename)->fit(80,80);  
            $fit->save($thumbnail_path.$filename);
            
            $image_thumbnail = "images/thumbnail/$filename";
            $image_original = "images/original/$filename";
            
            User::where("id",$user_id)->update([
                "path_image" => $image_original,
                "path_thumbnail" => $image_thumbnail
            ]);
            return response()->json(['status'=>'success',"message"=>"Imagen guardado!",'data'=>url($image_thumbnail)]);
        }
        return response()->json(['status'=>'error',"message"=>"Error al guardar!"]);

    }




    public function update(Request $request)
    {
        $user_id =  auth()->user()->id;

        // $empresa = Empresa::select('id','nombre','cuit','email','telefono','whatsapp','provincia','localidad','direccion')->where("user_id",$user_id)->first();

        $validator = \Validator::make($request->all(), [
            'nombre' => 'nullable|string|max:1000',
            'cuit' => 'nullable|string|max:30',
            'email' => 'nullable|email',
            'telefono' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $data = array();
        if(request()->nombre!==null) $data["nombre"] = request()->nombre ;
        if(request()->cuit!==null) $data["cuit"] = request()->cuit ;
        if(request()->email!==null) $data["email"] = request()->email;
        if(request()->telefono!==null) $data["telefono"] =  request()->telefono;
        if(request()->whatsapp!==null) $data["whatsapp"] = request()->whatsapp;
        if(request()->direccion!==null) $data["direccion"] = request()->direccion;

        $d = Empresa::where("user_id", $user_id)->update($data);

        if ($d) {
            return response()->json(["status" => "success", "message" => "Editado correctamente!"]);
        }
        return response()->json(["status" => "error", "message" => "Error al editar!"]);
    }


 


    




}
