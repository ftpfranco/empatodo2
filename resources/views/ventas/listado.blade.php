@extends('layouts.app')
@section('title')
    Listado de Ventas
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">

    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

@endsection
@section('content')
    <div class="page-heading mx-3 mb-1">
        <div class="d-flex justify-content-start">
            <h3>Listado de ventas</h3>
            
        </div>
    </div>

    <div class="page-content">
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0" id="table-hover-row">

                <div class="row m-0 p-0">

                    {{-- ganancias debito --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">D&eacute;bito</h6>
                                        <h6 class="font-extrabold mb-0 monto_debito">{{ isset($monto_debito) ?$monto_debito: 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ganancias Efectivo --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Efectivo</h6>
                                        <h6 class="font-extrabold mb-0 monto_efectivo">{{ isset($monto_efectivo) ?$monto_efectivo:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- ganancias Efectivo Pedidos ya --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Efectivo PedidosYa</h6>
                                        <h6 class="font-extrabold mb-0 monto_efectivo_pedidosya">{{ isset($monto_efectivo_pedidosya) ?$monto_efectivo_pedidosya:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- ganancias Creditos Pedidos ya --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Creditos PedidosYa</h6>
                                        <h6 class="font-extrabold mb-0 monto_credito_pedidosya">{{ isset($monto_credito_pedidosya) ?$monto_credito_pedidosya:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- cantidad de ventas --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4">
                                <div class="row ">
                                    <div class="col-4  ">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldDocument"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Cant de Ventas</h6>
                                        <h6 class="font-extrabold mb-0 cantidad_completas">{{ isset($cantidad_completas) ?$cantidad_completas :0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ganancias ventas --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldActivity"></i>
                                        </div>
                                    </div>
                                    <div class="col ">
                                        <h6 class="text-muted font-semibold">Ingresos</h6>
                                        <h6 class="font-extrabold mb-0 monto_completas">{{isset($monto_completas)?$monto_completas:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    {{-- egresos --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldActivity"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Egresos</h6>
                                        <h6 class="font-extrabold mb-0 monto_egreso">{{ isset($monto_egreso) ?$monto_egreso:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- total --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldGraph "></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Total neto</h6>
                                        <h6 class="font-extrabold mb-0 total">{{ isset($total) ?$total:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>



                <div class="col-12">

                    <div class="card mb-1 shadow">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="fecha_desde">Fecha desde</label>
                                            <input type="date" class="form-control fecha_desde filtro"  min="2021-11-19" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="fecha_hasta">Fecha hasta</label>
                                            <input type="date" class="form-control fecha_hasta filtro" min="2021-11-19" placeholder="">
                                        </div>
                                    </div>



                                    @if (isset($clientes) && count($clientes) > 0)
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                <select class=" choices cliente filtro" data-type="select-one" tabindex="0"
                                                    role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <option value="0" selected>Seleccione una opcion </option>
                                                    @foreach ($clientes as $key => $value)
                                                        <option value="{{ $key }}"> {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    @if (isset($empleados) && count($empleados) > 0)
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="">Empleado</label>
                                                <select class=" choices empleado filtro" data-type="select-one" tabindex="0"
                                                    role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <option value="0" selected>Seleccione una opcion </option>
                                                    @foreach ($empleados as $key => $value)
                                                        <option value="{{ $key }}"> {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

 

                                    @if (isset($tipo_envios) && count($tipo_envios) > 0)
                                        <div class="col-lg-3">
                                            <label for="first-name-vertical">Estado del pedido</label>
                                            <div class="col">
                                                <div class="form-group">
                                                    <select class=" form-select estadopedido filtro" id="estadopedido" >
                                                        <option value="-1">Todos </option>
                                                        @if (isset($tipo_envios) && !empty($tipo_envios))
                                                            @foreach ($tipo_envios as $key => $item)
                                                                <option value="{{ $key }}">{{ $item }}  </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    @if (isset($tipopagos) && count($tipopagos) > 0)
                                        <div class="col-lg-3">
                                            <label for="first-name-vertical">Tipos de pago</label>
                                            <div class="col">
                                                <div class="form-group">
                                                    <select class=" form-select tipopago filtro"  >
                                                        <option value="-1">Todos </option>
                                                        @if (isset($tipopagos) && !empty($tipopagos))
                                                            @foreach ($tipopagos as $key => $item)
                                                                <option value="{{ $key }}">{{ $item }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Estado de pago</label>
                                            <select class="form-select estadopago filtro" name="" id="">
                                                <option value="-1" selected> Todos </option>
                                                <option value="1">Completo </option>
                                                <option value="2"> Pendiente </option>
                                            </select>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class=" col-12">
                    <div class="card shadow">
                        <div class="card-content">
                            <div class="card-body" id="tabla">
                                
                                @include('ventas.listado_data')
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>





        {{-- <!--Basic Modal  detalles de venta--> --}}
        <div class="modal fade text-left" id="detalles-venta" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="myModalLabel11">DETALLE DE VENTA</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body modal-detalle">
 
                     
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                SALIR
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
@section('scripts')
    <script  src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}


    {{-- <script defer src="{{ asset('js/resources/ventas.listado_.js') }}">  </script> --}}
    <script defer src="{{ asset('js/ventas.listado.min.js') }}">  </script>

   
 
@endsection
