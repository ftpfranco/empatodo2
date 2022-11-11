<?php

namespace App\Http\Controllers;

use App\VentaDetallePago;
use App\Ventas;
use Illuminate\Http\Request;

class PagosController extends Controller
{

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect()->route("home");
        //
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric',
            'venta' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $id = request()->id;
        $venta_id = request()->venta;

        $venta = Ventas::select("id")->where("id", $venta_id)->where("eliminado", false)->first();
        if ($venta) {
            $pago =  VentaDetallePago::where("eliminado", false)->where("id", $id)->update(["eliminado" => true]);
            if ($pago) {
                $suma_pagos = VentaDetallePago::select(\DB::raw("sum(monto) monto"))->where("eliminado", false)->where("venta_id", $venta_id)->first();
                $pago = $suma_pagos["monto"];
                if ($suma_pagos["monto"] == 0 || $suma_pagos["monto"] == null) {
                    $pago = 0;
                }
                $data  = array();
                $data["total_recibido"] = $pago;
                if ($pago <= 0) {
                    $data["pago_completo"] = false;
                }
                Ventas::where("eliminado", false)->where("id", $venta_id)->update($data);

            }
        }

        return response()->json(["status" => "success",  "message" => "Eliminado!"]);
    }
}
