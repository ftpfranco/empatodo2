@extends('layouts.app')
@section('title')
    Compras nuevo
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')

    <a class="btn" href="{{url('compras')}}">  <i class="bi bi-arrow-left"></i> Volver atras</a>
    <div class="page-heading mx-3">
        <h3>Nueva compra</h3>
    </div>
    <div class="page-content">

        <section id="basic-vertical-layouts">

            <!-- caja cliente articulos  -->
            <div class="row match-height mx-0">
                <div class="col">
                    <div class="card">
                        <div class="card-content">

                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="form-body">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="first-name-vertical">Proveedor</label>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <select class=" choices proveedor" data-type="select-one"
                                                            tabindex="0" role="combobox" aria-autocomplete="list"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            {{-- <option value="1" selected>Selecciona una opcion</option> --}}
                                                            @if (isset($proveedores) && !empty($proveedores))
                                                                @foreach ($proveedores as $key => $item)
                                                                    <option value="{{ $key }}">{{ $item }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Fecha</label>
                                                    <input type="date" class="form-control fecha" name="fname"
                                                        placeholder="" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>






                                        <div class="row ">
                                            <label for="first-name-vertical">Articulos</label>
                                            <div class="col ">
                                                <div class="form-group">
                                                    <select class=" choices select-articulo" data-type="select-one"
                                                        tabindex="0" role="combobox" aria-autocomplete="list"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        @if (isset($articulos) && !empty($articulos))
                                                            @foreach ($articulos as $item)
                                                                    <option
                                                                    value="{{ $item['id'] }}_{{ $item['stock'] }}_{{ $item['precio_venta'] }}">{{ $item['articulo'] }}

                                                                    @if ($item['stock'] > 0)
                                                                        | stock: {{ $item['stock'] }}
                                                                    @endif
                                                                    @if ($item['precio_venta'])
                                                                        | precio: {{ $item['precio_venta'] }}
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="table">
                                            <!-- Table with outer spacing -->
                                            <div class="table-responsive mt-2">
                                                <table class="table table-hover mb-5">
                                                    <thead>
                                                        <tr>
                                                            <th>Articulo</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio compra</th>
                                                            <th>Precio venta</th>
                                                            <th>Subtotal</th>
                                                            <th>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="articulos-listado"> </tbody>
                                                    <tbody class="totales">
                                                        {{-- <tr class="table-active">
                                                            <td colspan="2"><strong>Descuento %</strong></td>
                                                            <td colspan="2">
                                                                <input type="text"
                                                                    class="form-control total-descuento-porcentaje"
                                                                    value="">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr> --}}

                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Descuento $ </strong></td>
                                                            <td colspan="2">
                                                                <input type="text"
                                                                    class="form-control total-descuento-monto" value="">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>

                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Subtotal general</strong></td>
                                                            <td colspan="2">
                                                                <input type="text" class="form-control total-subtotal"
                                                                    value="">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>

                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Total</strong></td>
                                                            <td colspan="2">
                                                                <input type="text" class="form-control total-total"
                                                                    value="">
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



                <!-- formas de pago  -->
                {{-- <div class="col-lg-4">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header">
                                <h4>Formas de pago</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-body">
                                    

                                    <div class="col">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Efectivo</label>
                                                    <input type="number" id="email-id-vertical"
                                                        class="form-control montos pago-efectivo" name="pago-efectivo"
                                                        placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Tarjeta Debito</label>
                                                    <input type="number" id="email-id-vertical"
                                                        class="form-control montos pago-debito" name="pago-debito"
                                                        placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Tarjeta Credito</label>
                                                    <input type="number" id="email-id-vertical"
                                                        class="form-control montos pago-credito" name="pago-credito"
                                                        placeholder="">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Cuenta Corriente</label>
                                                    <input type="number" id="email-id-vertical"
                                                        class="form-control montos pago-cc" name="pago-cc" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Cheque</label>
                                                    <input type="number" id="email-id-vertical"
                                                        class="form-control montos pago-cheque" name="pago-cheque"
                                                        placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Otro</label>
                                                    <input type="number" id="email-id-vertical"
                                                        class="form-control montos pago-otro" name="pago-otro"
                                                        placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col pt-1 pb-3">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Vuelto</label>
                                                <input type="text" disabled id="email-id-vertical"
                                                    class="form-control pago-vuelto" name="pago-vuelto" placeholder="">
                                            </div>
                                        </div>

                                    </div>




                                    <div class="form-group">
                                        <label for="email-id-vertical">Comentario adicional</label>
                                        <textarea type="textarea" id="email-id-vertical"
                                            class="form-control pago-comentario" name="pago-comentario"
                                            placeholder=""></textarea>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}




                <!-- formas de pago  -->
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header">
                                <h4>Agregar pago</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Tipo de pago</label>
                                                <select class=" choices tipopago" data-type="select-one" tabindex="0"
                                                    role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <option value="-1">Seleccione una opcion</option>
                                                    @if (isset($tipo_pagos) && count($tipo_pagos) > 0)
                                                        @if (isset($tipo_pagos) && !empty($tipo_pagos))
                                                            @foreach ($tipo_pagos as $key => $item)
                                                                <option value="{{ $key }}">{{ $item }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="monto">Monto</label>
                                                <input type="number" id="monto" class="form-control  monto" name="monto"
                                                    placeholder="">
                                            </div>
                                        </div>



                                    </div>


                                    <div class="form-group">
                                        <label for="tipopago_comentario">Comentario adicional</label>
                                        <textarea type="textarea" id="tipopago_comentario"
                                            class="form-control pago-comentario" name="pago-comentario"
                                            placeholder="..."></textarea>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>





                <div class="row mb-3">
                    <div class="col">
                        <button type="button" disabled
                            class="btn btn-lg btn-block btn-success me-1 mb-1 compra-guardar">Guardar</button>
                    </div>
                    {{-- <div class="col">
                        <button type="button" class="btn btn-lg btn-block btn-secondary me-1 mb-1 compra-factura"
                            disabled>Factura</button>
                    </div> --}}
                    {{-- <div class="col">
                        <!-- crear una factura electronia -->
                        <!-- <button type="button" class="btn btn-lg btn-secondary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#factura-electronica">Factura Electronica</button> -->
                        <!-- <button type="button" class="btn btn-lg btn-secondary me-1 mb-1">Factura Electronica</button> -->
                        <button type="button" class="btn btn-lg btn-block btn-secondary me-1 mb-1 compra-ticket"
                            disabled>Ticket</button>
                        <!-- registra la venta y emite comprobante  -->
                        <!-- <button type="button" class="btn btn-lg btn-secondary me-1 mb-1">Cobrar en caja</button> -->
                    </div> --}}
                </div>

            </div>


        </section>
    </div>




@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}

    {{-- <script defer src="{{ asset('js/resources/compras.nuevo.js')}}"></script> --}}
    <script defer src="{{ asset('js/compras.nuevo.min.js')}}"></script>
 
@endsection
