<div class="">

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Fecha</label>
                <input type="text" class="form-control" value="{{$compra->fecha}}" disabled>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Total</label>
                <input type="number" class="form-control" value="{{$compra->monto}}" disabled>
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Proveedor</label>
                <input type="text" class="form-control" value="{{$compra->proveedor_nombre}}" disabled>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Usuario</label>
                <input type="text" class="form-control" value="{{$compra->users_nombre}}" disabled>
            </div>
        </div>

    </div>

    <hr>
    {{-- <div class="mt-1 mb-1">
        <label for="pagos"><strong>Pagos</strong></label>
    </div> --}}

    <div class="col">
        <div class="form-group">
            <label for="">Estado Pago</label>
            <input type="text" class="form-control" value="{{$compra->pago_completo?"Completo":"Pendiente"}}" disabled>
        </div>
    </div>


    @if (isset($pagos) && count($pagos) > 0)
    <div class="col">
        <div class="form-group">
            <label for="">Pagos realizados</label>
        </div>
        <div class="form-group">
            @foreach ($pagos as $item)
                <label>{{ $item['tipo_pago'] }}: <strong>  {{ $item['monto'] }}</strong> </label>
            @endforeach
        </div>


        {{-- @if (isset($pagos) && count($pagos) > 0)
        <div class="card">
            <div class="card-content">
                <div class="card-header">
                    <h4>Pagos anteriores</h4>
                </div>
                <div class="card-body">
                    <div class="form-body">
                        @foreach ($pagos as $item)
                            <div class="col">
                                <div class="form-group">
                                    <label>{{ $item['tipo_pago'] }}: <strong>
                                            {{ $item['monto'] }}</strong> </label>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        @endif --}}

    </div>
    @endif 



    <div class="row">
        @if (isset($pagos) && !empty($pagos))
        @foreach ($pagos as $item)
        @if ($item["efectivo"])
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Efectivo</label>
                <input type="number" class="form-control" value="{{$item["efectivo"]}}" disabled>
            </div>
        </div>
        @endif
        @if ($item["debito"])
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Debito</label>
                <input type="number" class="form-control" value="{{$item["debito"]}}" disabled>
            </div>
        </div>
        @endif
        @if ($item["credito"])
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Credito</label>
                <input type="number" class="form-control" value="{{$item["credito"]}}" disabled>
            </div>
        </div>
        @endif
        @if ($item["cc"])
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Cuenta corriente</label>
                <input type="number" class="form-control" value="{{$item["cc"]}}" disabled>
            </div>
        </div>
        @endif
        @if ($item["otro"])
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Otro</label>
                <input type="number" class="form-control" value="{{$item["otro"]}}" disabled>
            </div>
        </div>
        @endif
        @if ($item["vuelto"])
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Vuelto</label>
                <input type="number" class="form-control" value="{{$item["vuelto"]}}" disabled>
            </div>
        </div>
        @endif
        @endforeach
        @endif
        
    </div>
    

    <hr>

    @if (isset($compra->comentario) && !empty($compra->comentario))
    <div class="col">
        <div class="form-group">
            <label for="email-id-vertical">Observaciones</label>
            <textarea disabled type="textarea" id="email-id-vertical" class="form-control pago-comentario"
                name="pago-comentario" placeholder="">{{$compra->comentario}}</textarea>
        </div>
    </div>
    <hr>
    @endif




    <div class="table-responsive mt-4">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Articulo</th>
                    <th>Cantidad</th>
                    <th>Precio compra</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($detalles) && !empty($detalles))
                @foreach ($detalles as $item)
                <tr>
                    <td>
                        <small> {{$item["articulo"]}}</small>
                    </td>
                    <td> {{$item["cantidad"]}}</td>
                    <td> {{$item["precio_compra"]}}</td>
                    <td> {{$item["subtotal"]}}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <tbody>
                <tr class="table-active">
                    <td><strong>Descuento %</strong></td>
                    <td colspan="3">
                        <input type="text" disabled class="form-control total-descuento-porcentaje" value="{{$compra->descuento_porcentaje}}">
                    </td>
                </tr>

                <tr class="table-active">
                    <td><strong>Descuento $ </strong></td>
                    <td colspan="3">
                        <input type="text" disabled class="form-control total-descuento-monto" value="{{$compra->descuento_monto}}">
                    </td>
                </tr>

                <tr class="table-active">
                    <td><strong>Subtotal general</strong></td>
                    <td colspan="3">
                        <input type="text" disabled class="form-control total-subtotal" value="{{$compra->subtotal}}">
                    </td>
                </tr>

                <tr class="table-active">
                    <td><strong>Total</strong></td>
                    <td colspan="3">
                        <input type="text" disabled class="form-control total-total" value="{{$compra->total}}">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
