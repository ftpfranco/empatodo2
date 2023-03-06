<?php

namespace App\Http\Controllers;

use App\Marca;
use App\Imagen;
use App\Precio;
use App\TasaIva;
use App\Articulo;
use App\Categorias;
use App\Notificacion;
use App\Subcategoria;
use Illuminate\Http\Request;
// use Mews\Purifier\Facades\Purifier;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        //'id','articulo','codigo','codigo_barras','stock','stock_minimo','marca_id',
        // 'categoria_id','subcategoria_id','precio_id','creator_id',
        // 'eliminado','created_at','updated_at'
        // $marcas = Marca::select('id', "marca")->where("eliminado",false)->pluck("marca", "id");
        $categorias = Categorias::select("id", "categoria")->where("eliminado",false)->pluck("categoria", "id");

        // $articulos = Articulo::select('id', 'articulo', 'codigo', 'precio_compra', 'precio_venta',  'stock', 'stock_minimo', 'marca_id', 'categoria_id',   'precio_id',   'habilitado', 'created_at', 'updated_at')
        //     ->where('eliminado', false)
        //     ->get();

        $articulos = Articulo::select('articulos.id', "articulos.nombre_corto",'articulos.articulo', 'articulos.codigo', 'articulos.precio_compra', 'articulos.precio_venta',  'articulos.stock', 'articulos.stock_minimo', 'articulos.marca_id', 'articulos.categoria_id', 'articulos.habilitado' , "categorias.categoria")
            // ->leftjoin("marca", "marca.id", "=", "articulos.marca_id")
            ->leftjoin("categorias", "categorias.id", "=", "articulos.categoria_id")
            ->orderby("articulos.id","asc")
            ->where('articulos.eliminado', false)
            ->paginate(15);

        return view("articulos.index", compact("articulos",  "categorias"));
    }


    public function filtro(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'marca' => 'nullable|numeric',
            'categoria' => 'nullable|numeric',
            'habilitado' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $marca_id = request()->marca ? request()->marca : null;
        $categoria_id = request()->categoria ? request()->categoria : null;
        $habilitado = request()->habilitado ? request()->habilitado : null;

        if($habilitado ==0) $habilitado_=null;
        if($habilitado ==1  ) $habilitado_=true;
        if($habilitado ==2  ) $habilitado_=false;

        $articulos = Articulo::select('articulos.id', 'articulos.articulo',"articulos.nombre_corto", 'articulos.codigo', 'articulos.precio_compra', 'articulos.precio_venta',  'articulos.stock', 'articulos.stock_minimo', 'articulos.marca_id', 'articulos.categoria_id', 'articulos.habilitado' ) // "marca.marca", "categorias.categoria"
            // ->leftjoin("marca", "marca.id", "=", "articulos.marca_id")
            // ->leftjoin("categorias", "categorias.id", "=", "articulos.categoria_id");
           ;

        if($marca_id!==null){
            $articulos = $articulos->where("articulos.marca_id",$marca_id);
        }
        if($categoria_id!==null){
            $articulos = $articulos->where("articulos.categoria_id",$categoria_id);
        }
        if ($habilitado_ !== null) {
            $articulos = $articulos->where("articulos.habilitado", $habilitado_);
        }
        
        $articulos = $articulos->where('articulos.eliminado', false) ;
        $articulos = $articulos->orderBy("articulos.id", 'desc');
        $articulos = $articulos->paginate(15);

        return response()->json(view("articulos.index_data", compact("articulos"))->render());
    }



    public function editar(Request $request, $id){
        
        
        $validator1 = \Validator::make(["id"=>$id],[
            'id' => 'required|numeric'
        ],[
            'id.required' => "El ArticuloId es obligatorio",
            "id.numeric" => "El ArticuloId no es correcto"
        ]);
        if ($validator1->fails()) {
            return redirect()->route("articulos.index");
            // return response()->json(["status" => "error", "message" => $validator1->errors()->all()],200);
        }  
        $articulo = Articulo::select('id', 'articulo', "nombre_corto",'codigo', 'precio_compra', 'precio_venta',  'stock', 'stock_minimo', 'marca_id', 'categoria_id'  )
        ->where("id",$id)
        ->where('eliminado', false)
        ->first();


        if(!$articulo){
            return redirect()->route("articulos.index");
        }

        // $marcas = Marca::select('id', "marca")->where("eliminado",false)->pluck("marca", "id");
        $categorias = Categorias::select("id", "categoria")->where("eliminado",false)->pluck("categoria", "id");


        return view("articulos.edit",compact("articulo", "categorias"));
    }

    public function edit(Request $request, $id)
    {
        // /'id','articulo','codigo','codigo_barras','stock','stock_minimo','marca_id',
        // 'categoria_id','subcategoria_id','precio_id','creator_id',
        // 'eliminado','created_at','updated_at'
        $validator1 = \Validator::make(["id"=>$id],[
            'id' => 'required|numeric'
        ],[
            'id.required' => "El ArticuloId es obligatorio",
            "id.numeric" => "El ArticuloId no es correcto"
        ]);
        if ($validator1->fails()) {
            return response()->json(["status" => "error", "message" => $validator1->errors()->all()],200);
        }  
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|string|max:500',
            'nombre_corto' => 'nullable|string|max:500',
            'codigo' => 'nullable|string|max:200',
            'stock' => 'nullable|numeric|max:999999.99',
            'stockminimo' => 'nullable|numeric|max:999999.99',
            // 'marca' => 'nullable|numeric|max:9999',
            'categoria' => 'nullable|numeric|max:9999',
            'preciocosto' => 'nullable|numeric|max:999999.99',
            'precioventa' => 'nullable|numeric|max:999999.99',
            // 'habilitado' => 'nullable|string',
            // 'nota_adicional'=>"string|max:5000"
        ],[
            "nombre.required" => "El Nombre del Articulo no es válido",
            "nombre.max" => "El Nombre del Articulo no es válido",
            "nombre_corto.required" => "El Nombre del Articulo no es válido",
            "nombre_corto.max" => "El Nombre del Articulo no es válido",
            "stock.max" => "El Stock ingresado no es válido",
            "stockminimo.max" => "El Stock Minimo ingresado no es válido",
            "preciocosto.max" => "El Precio de Compra ingresado no es válido",
            "precioventa.max" => "El Precio de Venta ingresado no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $nombre = request()->nombre ? request()->nombre : null;
        $nombre_corto = request()->nombre_corto ? request()->nombre_corto : null;
        $codigo = request()->codigo  ? request()->codigo : null;
        $stock = request()->stock ? request()->stock : 0;
        $stockminimo = request()->stockminimo ? request()->stockminimo : null;
        // $marca_id = request()->marca ? request()->marca : 0;
        $categoria_id = request()->categoria ? request()->categoria : 0;

        $precio_compra = request()->preciocosto ? request()->preciocosto : null;
        $precio_venta = request()->precioventa ?  request()->precioventa : null;
        // $habilitado =   request()->habilitado == "true" ? true : false;

        if($nombre) {
            // $nombre =  Purifier::clean($nombre);
            // $nombre = str_replace("&lt;?","",$nombre);
            $nombre = str_replace("--","",$nombre);
            $nombre = str_replace("'","",$nombre);
            $nombre = trim($nombre);
        }

        if($nombre_corto) {
            // $nombre_corto =  Purifier::clean($nombre_corto);
            // $nombre_corto = str_replace("&lt;?","",$nombre_corto);
            $nombre_corto = str_replace("--","",$nombre_corto);
            $nombre_corto = str_replace("'","",$nombre_corto);
            $nombre_corto = trim($nombre_corto);
        }

        $articulo =  Articulo::select("id", "precio_compra", "precio_venta", "stock")->where("id", $id)->where("eliminado", false)->first();

        if (!$articulo) {
            return response()->json(["status" => "error", "message" => "Error, no se pudo editar!"]);
        }

        // if($marca_id!==null|| $marca_id!==0) { $marca = Marca::select("marca")->where("id",$marca_id)->where("eliminado",false)->first();}
        if($categoria_id!==null|| $categoria_id!==0) { $categoria = Categorias::select("categoria")->where("id",$categoria_id)->where("eliminado",false)->first();}


        $precio_id = null;

        if($precio_compra!==null & $precio_venta!==null){
            if ((float)$precio_compra !== (float)trim($articulo["precio_compra"]) ||  (float)$precio_venta !== (float)trim($articulo["precio_venta"])) {
                $precio_id = Precio::create([
                    'precio_compra' => $precio_compra,
                    'precio_venta' => $precio_venta,
                    "articulo_id" => $articulo->id,
                ]);
                if ($precio_id) {
                    $precio_id = $precio_id->id;
                }
            }
        }


        $data =  array();
        $data["id"] = $id;
        $data["articulo"] = $nombre;
        $data["nombre_corto"] = $nombre_corto;
        $data["stock"] = $stock;
        $data["stock_minimo"] = $stockminimo;
        $data['precio_id'] = $precio_id;
        $data['precio_compra'] = $precio_compra;
        $data['precio_venta'] = $precio_venta;
        $data['habilitado'] = true;
        
        //  $data["marca_id"] = $marca_id;
          $data["categoria_id"] = $categoria_id;
       
        $articulo = Articulo::where("id", $id)->where("eliminado", false)->update($data);

        if($articulo){
            Notificacion::where("articulo_id",$id)->update(["eliminado"=>true]);
        }

        // if(!empty($marca))   $data["marca"] = $marca->marca;
        if(!empty($categoria)) $data["categoria"] = $categoria->categoria;    

        if (request()->file('image')) {
            $cover = request()->file('image');
            $extension = $cover->getClientOriginalExtension();
            // $original_filename = $cover->getClientOriginalName();
            // $filename = $cover->getFilename().'.'.$extension;
            $filename = microtime(true) . '.' . $extension;
            $path = public_path('/images/original/');
            $cover->move($path, $filename);

            // $thumbnail_path = public_path('/images/thumbnail/');
            // $fit = Image::make($path.$filename)->fit(40,40);
            // $fit->save($thumbnail_path.$filename);

            $image_40 = "images/thumbnail/$filename";
            // $user = User::where('id',$creator_id)->update([
            //     'img_40' => $image_40
            // ]);
        }
        if ($articulo) {
            return response()->json(["status" => "success", "message" => "Editado!","data"=>$data]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);
    }




    public function stock(Request $request)
    {
        // /'id','articulo','codigo','codigo_barras','stock','stock_minimo','marca_id',
        // 'categoria_id','subcategoria_id','precio_id','creator_id',
        // 'eliminado','created_at','updated_at'

        $validator = \Validator::make($request->all(), [
            'id' => 'nullable|numeric',
            'stock' => 'nullable|numeric|max:999999.99',
            // 'nota_adicional'=>"string|max:5000"
        ],[
            "stock.numeric" => "El Stock ingresado no es válido",
            "stock.max" => "El Stock ingresado no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $id = request()->id ? request()->id : 0;
        $stock = request()->stock ? request()->stock : 0;
 

        $articulo =  Articulo::select("id", "precio_compra", "precio_venta", "stock")->where("id", $id)->where("eliminado", false)->first();
        if (!$articulo) {
            return response()->json(["status" => "error", "message" => "Error, no se pudo editar!"]);
        }

        $stock_anterior = $articulo->stock;
        
        $articulo = Articulo::where("id", $id)->where("eliminado", false)->increment("stock",$stock);
        

        if($articulo){
            Notificacion::where("articulo_id",$id)->update(["eliminado"=>true]);
        }
        

        $stock_actual = $stock_anterior + $stock;

        $data =  array();
        $data["id"] = $id; 
        $data["stock_incremet"] = $stock; 
        $data["stock_anterior"] = $stock_anterior; 
        $data["stock_actual"] = $stock_actual; 

        if ($articulo) {
            return response()->json(["status" => "success", "message" => "Editado!","data"=>$data]);
        }
        return response()->json(["status" => "error", "message" => "Error!"]);
    }






    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // /'id','articulo','codigo','codigo_barras','stock','stock_minimo','marca_id',
        // 'categoria_id','subcategoria_id','precio_id','creator_id',
        // 'eliminado','created_at','updated_at'

        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|string|max:500',
            'nombre_corto' => 'required|string|max:500',
            'codigo' => 'nullable|string|max:200',
            'stock' => 'nullable|numeric|max:999999.99',
            'stockminimo' => 'nullable|numeric|max:999999.99',
            'marca' => 'nullable|numeric|max:9999',
            'categoria' => 'nullable|numeric|max:9999',
            'preciocosto' => 'nullable|numeric|max:999999.99',
            'precioventa' => 'nullable|numeric|max:999999.99',
            // 'habilitado' => 'nullable|string',
            // 'nota_adicional'=>"string|max:5000"
        ],[
            "nombre.required" => "El Nombre del Articulo no es válido",
            "nombre.max" => "El Nombre del Articulo no es válido",
            "nombre_corto.required" => "El Nombre del Articulo no es válido",
            "nombre_corto.max" => "El Nombre del Articulo no es válido",
            "stock.max" => "El Stock ingresado no es válido",
            "stockminimo.max" => "El Stock Minimo ingresado no es válido",
            "preciocosto.max" => "El Precio de Compra ingresado no es válido",
            "precioventa.max" => "El Precio de Venta ingresado no es válido"
        ]);

        if ($validator->fails()) {
            return response()->json(["status"=>"error",'message' => $validator->errors()->all()]);
        }

        $articulo = request()->nombre ? request()->nombre : null;
        $nombre_corto = request()->nombre_corto ? request()->nombre_corto : null;
        $codigo = request()->codigo  ? request()->codigo : null;
        $stock = request()->stock ? request()->stock : 0;
        $stockminimo = request()->stockminimo ? request()->stockminimo : null;
        $marca_id = request()->marca ? request()->marca : 0;
        $categoria_id = request()->categoria ? request()->categoria : 0;

        $precio_compra = request()->preciocosto ? request()->preciocosto : null;
        $precio_venta = request()->precioventa ?  request()->precioventa : null;
        // $habilitado =  request()->habilitado? request()->habilitado:false;

        if($articulo) {
            // $articulo =  Purifier::clean($articulo);
            // $articulo = str_replace("&lt;?","",$articulo);
            $articulo = str_replace("--","",$articulo);
            $articulo = str_replace("'","",$articulo);
            $articulo = trim($articulo);
        }

        if($nombre_corto) {
            // $nombre_corto =  Purifier::clean($nombre_corto);
            // $nombre_corto = str_replace("&lt;?","",$nombre_corto);
            $nombre_corto = str_replace("--","",$nombre_corto);
            $nombre_corto = str_replace("'","",$nombre_corto);
            $nombre_corto = trim($nombre_corto);
        }


        if($marca_id!==null|| $marca_id!==0) { $marca = Marca::select("marca")->where("id",$marca_id)->where("eliminado",false)->first();}
        if($categoria_id!==null|| $categoria_id!==0) { $categoria = Categorias::select("categoria")->where("id",$categoria_id)->where("eliminado",false)->first();}

        // precio
        // 'id','precio_neto','precio_compra','precio_venta','precio_descuento_porc','precio_descuento_impor','estado',
        // 'user_id','creator_id','eliminado','created_at','updated_at'
        // 'precio_compra'=> $precio_compra,
        // 'precio_venta'=> $precio_venta,
        // 'precio_neto_venta'=> $precio_neto_venta,
        // TasaIva::create(["tasaiva"=>"Iva 0%"]);
        // TasaIva::create(["tasaiva"=>"Iva 10.5%"]);
        // TasaIva::create(["tasaiva"=>"Iva 21%"]);
        // TasaIva::create(["tasaiva"=>"Iva 27%"]);
        // TasaIva::create(["tasaiva"=>"Iva 5%"]);
        // TasaIva::create(["tasaiva"=>"Iva 2,5%"]);
        // TasaIva::create(["tasaiva"=>"No Grabado"]);
        // TasaIva::create(["tasaiva"=>"Excento"]);

        $precio_id = Precio::create([
            'precio_compra' => $precio_compra,
            'precio_venta' => $precio_venta,
        ]);
        $precio_id = $precio_id->id;

        $data =  array();
        $data["articulo"] = $articulo;
        $data["nombre_corto"] = $nombre_corto;
        $data["stock"] = $stock;
        $data["stock_minimo"] = $stockminimo;
        $data['precio_id'] = $precio_id;
        $data['precio_compra'] = $precio_compra;
        $data['precio_venta'] = $precio_venta;
        $data['habilitado'] = true;
        
         $data["marca_id"] = $marca_id;
         $data["categoria_id"] = $categoria_id;

        $articulo = Articulo::create($data);

        $data["id"]= $articulo->id;
        if(!empty($marca))   $data["marca"] = $marca->marca;
        if(!empty($categoria)) $data["categoria"] = $categoria->categoria;    

        // if (request()->file('image')) {
        //     $cover = request()->file('image');
        //     $extension = $cover->getClientOriginalExtension();
        //     // $original_filename = $cover->getClientOriginalName();
        //     // $filename = $cover->getFilename().'.'.$extension;
        //     $filename = microtime(true) . '.' . $extension;
        //     $path = public_path('/images/original/');
        //     $cover->move($path, $filename);

        //     // $thumbnail_path = public_path('/images/thumbnail/');
        //     // $fit = Image::make($path.$filename)->fit(40,40);
        //     // $fit->save($thumbnail_path.$filename);

        //     $image_40 = "images/thumbnail/$filename";
        //     // $user = User::where('id',$creator_id)->update([
        //     //     'img_40' => $image_40
        //     // ]);
        // }
        if ($articulo) {
            return response()->json(["status" => "success", "message" => "Guardado!","data"=>$data]);
        }
        return response()->json(["status" => "error", "message" => "Error, no se pudo guardar!"]);
    }


    public function images(Request $request, $articulo)
    {
        $creator_id = auth()->user()->creator_id;
        $art = $request->validate([
            'image' => 'required|mimes:jpeg,bmp,png,ico|max:900000'
        ]);

        $item = Articulo::where('eliminado', false)
            ->where("id", $articulo)
            ->where('creator_id', $creator_id)
            ->first();
        if (!$item) {
            return response()->json(["status" => "error", "message" => "Error,no se pudo guardar!"]);
        }

        $cover = request()->file('image');
        $extension = $cover->getClientOriginalExtension();

        $filename = microtime(true) . '.' . $extension;
        $path = public_path('/images/original/');
        $cover->move($path, $filename);

        $image_40 = "images/thumbnail/$filename";
        $i = Imagen::create([
            'articulo_id' => $articulo,
            'creator_id' => $creator_id,
            'imagen' => $filename,
            'original' => url($image_40),
            'thumbnails' => url($image_40)
        ]);
        $array = array(
            'articulo_id' => $articulo,
            'creator_id' => $creator_id,
            'imagen' => $filename,
            'original' => url($image_40),
            'thumbnails' => url($image_40)
        );
        if ($i) {
            return response()->json(["status" => "success", "array" => $array, "message" => "Articulo creado correctamente!"]);
        }
        return response()->json(["status" => "error", "message" => "Error al crear articulo!"]);
    }

    public function imagesDelete(Request $request, $articulo, $image)
    {
        $creator_id = auth()->user()->creator_id;

        $item = Articulo::where('eliminado', false)
            ->where("id", $articulo)
            ->where('creator_id', $creator_id)
            ->first();
        if (!$item) {
            return response()->json(["status" => "error", "message" => "Error al crear articulo!"]);
        }

        $i = Imagen::where('articulo_id', $articulo)
            ->where("id", $image)
            ->where("eliminado", false)
            ->where('creator_id', $creator_id)
            ->update(["eliminado" => true]);

        if ($i) {
            return response()->json(["status" => "success", "message" => "Articulo imagen eliminado correctamente!"]);
        }
        return response()->json(["status" => "error", "message" => "Error al eliminar articulo imagen!"]);
    }




    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         
        $validator1 = \Validator::make(["id"=>$id],[
            'id' => 'required|numeric'
        ],[
            'id.required' => "El ArticuloId es obligatorio",
            "id.numeric" => "El ArticuloId no es correcto"
        ]);
        if ($validator1->fails()) {
            // return redirect()->route("articulos.index");
            return response()->json(["status" => "error", "message" => $validator1->errors()->all()],200);
        }  

        // $creator_id = auth()->user()->creator_id;
        $s = Articulo::where('id', $id)->where("eliminado", false)->update([
            "eliminado" => true
        ]);

        if ($s) {
            return response()->json([
                "status" => "success",
                "message" => "Eliminado!"
            ]);
        }

        return response()->json(["status" => "error", "message" => "Error, no se pudo eliminar!"]);
    }
}
