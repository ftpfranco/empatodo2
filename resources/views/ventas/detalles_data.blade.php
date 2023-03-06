<div>
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-2">
            <label for=""> <strong>Fecha: </strong> </label>
            <label for=""> {{ $venta->fecha ? $venta->fecha  : '' }}  </label>
            <br>
            <label for=""> <strong>Total:</strong> </label>
            <label for="">{{ $venta->monto ? $venta->monto : '' }}</label>
            <br>
            <label for=""> <strong>Cliente:</strong> </label>
            <label for=""> {{ $venta->cliente ? $venta->cliente : 'Sin datos' }} </label>
        </div>

        <div class="col-lg-6 col-md-6 mb-2">
            <label for=""> <strong>Estado Pago:</strong> </label>
            <label for=""> {{ $venta->pago_completo ? 'Completo' : 'Pendiente' }} </label>
            <br>
            <label for=""> <strong>Estado del pedido:</strong> </label>
            <label for=""> {{  $venta->estado_envio ?  $venta->estado_envio : 'Sin datos' }} </label>
        </div>
        <hr> 
        
        <div class="col">

         
                <div class="col-12 my-2">
                    <h5> Pagos recibidos </h5>
                </div>
                @if (isset($pagos) && !empty($pagos))
                    @foreach ($pagos as $item)
                        <label for=""> <strong> {{$item->tipo_pago}}: </strong></label> 
                        <label for=""> {{$item->monto ? $item->monto : 0}} </label>
                    @endforeach
                @else
                    <label for=""> Sin datos </label>
                @endif
                <hr>



                @if (isset($venta->comentario) && !empty($venta->comentario))
                    <div class="col-12 my-2">
                        <h5> Observaciones </h5>
                    </div>
                    <textarea disabled type="textarea" id="email-id-vertical" class="form-control pago-comentario"  name="pago-comentario" placeholder="">{{ $venta->comentario }}</textarea>
                    <hr>
                @endif

                <div class="col-12 my-2">
                    <h5> Articulos  </h5>
                </div>

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

    

  
     
</div>
