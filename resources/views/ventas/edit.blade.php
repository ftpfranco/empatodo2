@extends('layouts.app')
@section('title')
    Ventas editar
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')

    <div class="page-heading mx-3">
        <a class="btn" href="{{url('ventas-diarias')}}">  <i class="bi bi-arrow-left"></i> Volver atras</a>

        <h3>Editar venta</h3>
    </div>
    <div class="page-content">

        <section id="basic-vertical-layouts">


            {{-- <!-- caja cliente articulos  --> --}}
            <div class="row match-height mx-0">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="form-body">


                                        <div class="row">
                                            <div class="col-lg-4 mt-1 mb-1">
                                                <label for="first-name-vertical">Cliente</label>
                                                <div class="col">
                                                    <div class="form-group">
                                                         
                                                        <input type="text" class="form-control  cliente"   placeholder="" value="{{$venta->cliente}}"  >
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="text" hidden class="venta-id" data-id="{{$venta->id}}">
                                            <div class="col-lg-4 mt-1 mb-1">
                                                <div class="form-group">
                                                    <label>Fecha</label>
                                                    <input type="date" class="form-control fecha"  
                                                        placeholder="" value="{{ $venta->fecha }}">
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-lg-4 mt-1 mb-1">
                                                <label for="first-name-vertical">Estado del pedido</label>
                                                <div class="row d-flex justify-content-start">
                                                    {{-- <div class="form-group">
                                                        <select class="form-select  tipoenvio" data-type="select-one"
                                                            tabindex="0" role="combobox" aria-autocomplete="list"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <option value="-1">Seleccione una opcion</option>
                                                            @if (isset($tipo_envios) && count($tipo_envios) > 0)
                                                                @if (isset($tipo_envios) && !empty($tipo_envios))
                                                                    @foreach ($tipo_envios as $key => $item)
                                                                        <option value="{{ $key }}">{{ $item }}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div> --}}

                                                    @if (isset($tipo_envios) && count($tipo_envios) > 0)
                                                        @if (isset($tipo_envios) && !empty($tipo_envios))
                                                            @foreach ($tipo_envios as $key => $item)
                                                            <div class="col-6">
                                                                <div class="form-check  mt-2">
                                                                    <label class="form-check-label estado_pedido" >
                                                                        <input class="form-check-input" type="radio" name="estado_pedido" value="{{$key}}" >
                                                                        {{$item}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                            
                                        </div>






                                         
                                        <div class="row mt-3 mb-1 pt-3">
                                            <label for="first-name-vertical">Articulo</label>
                                             
                                            
                                            
                                            <div class="col-lg-6">
                                                @if (isset($articulos) && !empty($articulos))
                                                    @foreach ($articulos as $item)
                                                        @if (isset($item["categoria_id"]) && $item["categoria_id"] ==2 )
                                                        <div class="col  mt-3 d-flex justify-content-beetwen">
                                                            <div class="col-8">
                                                                <input type="text" class="form-control " disabled value="{{ $item['articulo'] }} | ${{ $item['precio_venta'] }}">
                                                                
                                                            </div>
                                                            <div class="col-4 mx-2 d-flex justify-content-center "> 
                                                                <input type="text" hidden class="hidden articulo-precio" data-articuloid="{{ $item['id'] }}" value="{{ $item['precio_venta'] }}">
                                                                <div>
                                                                    <label class="btn btn-sm btn-danger px-3 pt-2 pb-2 boton-decrementar"> <strong>-</strong> </label>
                                                                </div>
                                                                <div class="form-group col-md-3 mx-2">
                                                                    <input type="number" min="0" class="form-control  cantidad  px-1 mx-1" value="{{isset($item["cantidad"])?$item["cantidad"]:'' }}">
                                                                </div>
                                                                <div>
                                                                    <label class="btn btn-sm btn-success px-3 pt-2 pb-2 boton-incrementar"> <strong>+</strong></label>
                                                                </div>
                                                                <input type="number" hidden class="subtotales hidden">
                                                            </div>

                                                        </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                @if (isset($articulos) && !empty($articulos))
                                                    @foreach ($articulos as $item)
                                                        @if (isset($item["categoria_id"]) && $item["categoria_id"] ==1 )
                                                        <div class="col  mt-3 d-flex justify-content-beetwen">
                                                            <div class="col-8">
                                                                <input type="text" class="form-control " disabled value="{{ $item['articulo'] }} | ${{ $item['precio_venta'] }}">
                                                                
                                                            </div>
                                                            <div class="col-4 mx-2 d-flex justify-content-center "> 
                                                                <input type="text" hidden class="hidden articulo-precio" data-articuloid="{{ $item['id'] }}" value="{{ $item['precio_venta'] }}">
                                                                <div>
                                                                    <label class="btn btn-sm btn-danger px-3 pt-2 pb-2 boton-decrementar"><strong>-</strong></label>
                                                                </div>
                                                                <div class="form-group col-md-3 mx-2">
                                                                    <input type="number" min="0" class="form-control  cantidad  px-1 mx-1" value="{{isset($item["cantidad"])?$item["cantidad"]:''}}">
                                                                </div>
                                                                <div>
                                                                    <label class="btn btn-sm btn-success px-3 pt-2 pb-2 boton-incrementar"><strong>+</strong></label>
                                                                </div>
                                                                <input type="number" hidden class="subtotales hidden">
                                                            </div>

                                                        </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>

                                        </div>

                                        <div class="table mt-1 mb-1">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-hover mb-5">
                                                   
                                                    <tbody class="totales">
                                                        
                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Total</strong></td>
                                                            <td colspan="2">
                                                                <input type="text" class="form-control total-subtotal"
                                                                    value="{{$venta->monto}}">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>

                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Descuento   </strong></td>
                                                            <td colspan="2">
                                                                <input type="text"
                                                                    class="form-control total-descuento-monto" value="{{$venta->descuento_importe }}">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>

                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Total a pagar</strong></td>
                                                            <td colspan="2">
                                                                <input type="text" class="form-control total-total"
                                                                    value="{{$venta->total_apagar}}">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
                
                

                {{-- <!-- formas de pago  --> --}}
                <div class="col-lg-3 ">
                    <div class="card shadow">
                        <div class="card-content">
                            <div class="card-header">
                                <h4>Agregar pago</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-12 mt-1 mb-1">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Seleccione un metodo de pago</label>

                                                <div>
                                                    @if (isset($tipo_pagos) && count($tipo_pagos) > 0)
                                                        @if (isset($tipo_pagos) && !empty($tipo_pagos))
                                                            @foreach ($tipo_pagos as $key => $item)
                                                            <div class="form-check  mt-2">
                                                                <label class="form-check-label tipo_radio" >
                                                                    <input class="form-check-input  " type="radio" name="tipo_pago"    value="{{$key}}" >
                                                                   {{$item}}
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-1 mb-1">
                                            <div class="form-group">
                                                <label for="monto">Total a pagar</label>
                                                <label for="" class="calcular-monto">   </label>
                                                <input type="number" id="monto"
                                                    class="form-control  monto" name="monto"
                                                    placeholder="">
                                            </div>
                                        </div>



                                    </div>


                                    <div class="form-group mt-1 mb-1">
                                        <label for="tipopago_comentario">Comentario adicional</label>
                                        <textarea type="textarea" id="tipopago_comentario"
                                            class="form-control pago-comentario" name="pago-comentario"
                                            placeholder="..."></textarea>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        
                        @if (isset($pagos) && count($pagos) > 0)
                            <div class="card shadow">
                                <div class="card-content">
                                    <div class="card-header">
                                        <h4>Pagos anteriores</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-body">
                                            @foreach ($pagos as $item)
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="pago-anterior" data-monto="{{ $item['monto'] }}">{{$item["tipo_pago"]}}: <strong> {{ $item['monto'] }}</strong> 
                                                        @can('venta-pago-destroy')
                                                         <span class="eliminar-pago" data-id="{{$item["id"]}}" data-venta="{{$venta->id}}" data-bs-toggle="tooltip"  data-bs-placement="top" title="Eliminar pago" data-bs-original-title="Eliminar pago" style="color: red">X</span>
                                                        @endcan
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>



                </div>




               






                <div class="row p-0 m-0 mb-3">
                    <div class="col-lg-6 mt-1 mb-1">
                        <button type="button"
                            class="btn  btn-block btn-success me-1 mb-1 venta-guardar disabled" disabled >GUARDAR</button>
                    </div>
                    {{-- <div class="col-lg-6 mt-1 mb-1">
                        <button type="button"
                            class="btn  btn-block btn-secondary me-1 mb-1 venta-factura">Factura</button>
                    </div> --}}
                    <div class="col-lg-6 mt-1 mb-1"> 
                        <button type="button"  class="btn  btn-block btn-secondary me-1 mb-1 venta-ticket disabled" disabled>GUARDAR Y GENERAR TICKET</button>
                    </div>
                </div>

            </div>


        </section>







 
    </div>


@endsection

@section('scripts')

    {{-- <script src="{{ asset('assets/js/extensions/sweetalert2.js') }}"></script> --}}
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}


    {{-- <script src="{{ asset('js/resources/ventas.edit.js') }}">  </script> --}}
    <script defer src="{{ asset('js/ventas.edit.min.js') }}">  </script>

   
     
@endsection
