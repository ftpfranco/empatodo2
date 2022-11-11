<div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Fecha</label>
                <input type="text" class="form-control" value="{{ $venta->fecha }}" disabled>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Total</label>
                <input type="text" class="form-control" value="{{ $venta->monto }}" disabled>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="">Cliente</label>
                <input type="text" class="form-control" value="{{ $venta->cliente }}" disabled>
            </div>
        </div>
        {{-- <div class="col-lg-6">
            <div class="form-group">
                <label for="">Usuario</label>
                <input type="text" class="form-control" value="{{ $venta->user_nombre }}" disabled>
            </div>
        </div> --}}

    </div>



    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Estado Pago</label>
                <input type="text" class="form-control"
                    value="{{ $venta->pago_completo ? 'Completo' : 'Pendiente' }}" disabled>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Estado del pedido</label>
                <input type="text" class="form-control" value="{{ $venta->estado_envio }}" disabled>
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-12 my-2">
            <label for="">Pagos recibidos</label>
        </div>
        @if (isset($pagos) && !empty($pagos))
            @foreach ($pagos as $item)
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">{{$item->tipo_pago}}</label>
                        <input type="text" class="form-control" value="{{$item->monto }}" disabled>
                    </div>
                </div>
                {{-- @if ($item['efectivo'])
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Efectivo</label>
                            <input type="text" class="form-control" value="{{ $item['efectivo'] }}" disabled>
                        </div>
                    </div>
                @endif
                @if ($item['debito'])
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Debito</label>
                            <input type="text" class="form-control" value="{{ $item['debito'] }}" disabled>
                        </div>
                    </div>
                @endif
                @if ($item['credito'])
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Credito</label>
                            <input type="text" class="form-control" value="{{ $item['credito'] }}" disabled>
                        </div>
                    </div>
                @endif
                @if ($item['pedidosya'])
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">PedidosYa</label>
                            <input type="text" class="form-control" value="{{ $item['pedidosya'] }}" disabled>
                        </div>
                    </div>
                @endif
                @if ($item['cc'])
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">CCorriente</label>
                            <input type="text" class="form-control" value="{{ $item['cc'] }}" disabled>
                        </div>
                    </div>
                @endif
                @if ($item['otro'])
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Otro</label>
                            <input type="text" class="form-control" value="{{ $item['otro'] }}" disabled>
                        </div>
                    </div>
                @endif
                @if ($item['vuelto'])
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Vuelto</label>
                            <input type="text" class="form-control" value="{{ $item['vuelto'] }}" disabled>
                        </div>
                    </div>
                @endif --}}
            @endforeach
        @endif

        <hr>

        @if (isset($venta->comentario) && !empty($venta->comentario))
            <div class="col">
                <div class="form-group">
                    <label for="email-id-vertical">Observaciones</label>
                    <textarea disabled type="textarea" id="email-id-vertical" class="form-control pago-comentario"
                        name="pago-comentario" placeholder="">{{ $venta->comentario }}</textarea>
                </div>
            </div>
            <hr>
        @endif


        <div class="table-responsive mt-4">
            <table class="table table-hover mb-0 table-striped">
                <thead>
                    <tr>
                        <th>Articulo</th>
                        <th class="text-end">Cantidad</th>
                        <th class="text-end">Precio</th>
                        {{-- <th>Descuento</th> --}}
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($detalles) && !empty($detalles))
                        @foreach ($detalles as $item)
                            <tr>
                                <td class=" text-articulo">
                                    <small>{{ $item['articulo'] }}</small>
                                </td>
                                <td data-label="Cantidad:" class="text-end"> {{ $item['cantidad'] }} </td>
                                <td data-label="Precio:" class="text-end"> {{ $item['precio'] }} </td>
                                {{-- <td> {{$item["descuento"]}} </td> --}}
                                <td data-label="Subtotal:" class="text-end"> {{ $item['subtotal'] }} </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                
            </table>
            <br> 
           <table class="table table-hover mb-0">
            <tbody class="foo">
                {{-- <tr class="table-active">
                    <td><strong>Descuento %</strong></td>
                    <td colspan="4">
                        <input type="text" disabled class="form-control total-descuento-porcentaje" value="{{$venta->descuento_porcentaje}}">
                    </td>
                </tr> --}}

               

                <tr>
                    <td class="td-disable"><strong>Total: </strong></td>
                    <td data-label="Total" colspan="4" class="text-end">
                        {{-- <input type="text" disabled class="form-control total-subtotal text-end"
                            value="{{ $venta->monto }}"> --}}
                            <span> {{ $venta->monto }} </span>
                    </td>
                </tr>

                <tr>
                    <td class="td-disable" ><strong>Descuento:  </strong></td>
                    <td data-label="Descuento" colspan="4" class="text-end">
                        {{-- <input type="text" disabled class="form-control total-descuento-monto text-end"
                            value="{{ $venta->descuento_importe }}"> --}}
                            <span>{{ $venta->descuento_importe }} </span>
                    </td>
                </tr>

                <tr>
                    <td class="td-disable"  ><strong>Total a pagar:</strong></td>
                    <td data-label="Total a pagar" colspan="4" class="text-end">
                        {{-- <input type="text" disabled class="form-control total-total text-end" value="{{ $venta->total_apagar }}"> --}}
                        <span> {{ $venta->total_apagar }} </span>
                    </td>
                </tr>
            </tbody>
           </table>
        </div>
    </div>
</div>
