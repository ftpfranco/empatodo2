<?php

namespace App\Http\Controllers;

use App\Ventas;
use Illuminate\Http\Request;
use App\VentaDetalleArticulo;

class MostradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // 1	"Ordenado"
        // 2	"En preparacion"
        // 3	"Enviado"
        // 4	"Cancelado"
        // $turno_mañana = "11:00 - 16:00";
        $t1_hora_desde = '07:30';
        $t1_hora_hasta = '16:00';

        $t2_hora_desde = '16:01';
        $t2_hora_hasta = '00:00';

        if (  date("H:i") >= $t2_hora_hasta && date("H:i") <= $t1_hora_desde    ) {
            $ventas = array();
            return view('mostrador.index', compact('ventas'));
        }
        
        $venta = Ventas::select('ventas.id',   'ventas.cliente',  'ventas_detalle_articulo.cantidad',"ventas.created_at", 'ventas_detalle_articulo.articulo')
            ->leftjoin('ventas_detalle_articulo',  'ventas_detalle_articulo.venta_id',   '=',  'ventas.id')
            ->where('ventas.eliminado', false)
            ->where('ventas.fecha', date('Y-m-d'))
            ->whereIn('ventas.tipoenvio_id', [1, 2])
            ;
        if (date("H:i") >= $t1_hora_desde && date("H:i") <= $t1_hora_hasta) {
            $venta = $venta->where("ventas.hora", ">=", $t1_hora_desde)->where("ventas.hora", "<=", $t1_hora_hasta);
        }
        if(date("H:i")>=$t2_hora_desde && date("H:i")<= $t2_hora_hasta){
            $venta = $venta->where("ventas.hora", ">=", $t2_hora_desde)->where("ventas.hora", "<=", $t2_hora_hasta);
        }

        $venta = $venta ->orderby('ventas.id', 'desc') ->get();

        $data = [];
        if ($venta) {
            foreach ($venta as $key => $value) {
                $data[$value->id]['venta_id'] = $value->id;
                $data[$value->id]['cliente'] = $value->cliente;
                $data[$value->id]['created_at'] = $value->created_at;
                $data[$value->id]['articulos'][] = [
                    'cantidad' => $value->cantidad,
                    'articulo' => $value->articulo,
                ];
                // $data[$value->id]["articulos"]["articulo"][]= $value->articulo;
            }
        }
        $ventas = $data;
        return view('mostrador.index', compact('ventas'));
    }

    public function editarpedido(Request $request)
    {
        $user_id = auth()->user()->id;

        $validator = \Validator::make($request->all(), [
            'venta_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $venta_id = request()->venta_id;
        $tipoenvio_id = 3; // enviado
        // 1	"Ordenado"
        // 2	"En preparacion"
        // 3	"Enviado"
        // 4	"Cancelado"
        $venta = Ventas::where('id', $venta_id)->update([
            'tipoenvio_id' => $tipoenvio_id,
        ]);

        if ($venta) {
            return response()->json([
                'status' => 'success',
                'venta_id' => $venta_id,
                'message' => 'Guardado!',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Error al guardar!',
        ]);
    } // end editar pedido

    
}
