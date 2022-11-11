@extends('layouts.app')
@section('title')
    Ventas
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">

    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

@endsection
@section('content')


    <div class="page-heading mx-3 mb-1">
        <div class="mb-3 mt-0">
            <a class="btn btn-outline-success mx-1 " href="{{ url('ventas/nuevo') }}"><strong>+</strong>NUEVO</a>
        </div>
        <div class="d-flex justify-content-start">
            <h3>Ventas del dia</h3>
        </div>
    </div>


    <div class="page-content">

        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="row m-0 p-0 ">
                    
                    {{-- cantidad de ventas --}}
                    <div class="col-lg-2 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4-5">
                                <div class="row ">
                                    <div class="col-4  ">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldDocument"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Ventas</h6>
                                        <h6 class="font-extrabold mb-0">{{$cantidad_completas ?$cantidad_completas :0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ganancias ventas --}}
                    <div class="col-lg-2 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldActivity"></i>
                                        </div>
                                    </div>
                                    <div class="col ">
                                        <h6 class="text-muted font-semibold">Ganancias</h6>
                                        <h6 class="font-extrabold mb-0">{{$monto_completas?$monto_completas:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ganancias debito --}}
                    <div class="col-lg-2 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Debito</h6>
                                        <h6 class="font-extrabold mb-0">{{$monto_debito?$monto_debito: 0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ganancias credito --}}
                    <div class="col-lg-2 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Credito</h6>
                                        <h6 class="font-extrabold mb-0">{{$monto_credito?$monto_credito:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- egresos --}}
                    <div class="col-lg-2 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldActivity"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Egresos</h6>
                                        <h6 class="font-extrabold mb-0">{{$monto_egreso?$monto_egreso:0}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- total --}}
                    <div class="col-lg-2 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldGraph "></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Total neto</h6>
                                        <h6 class="font-extrabold mb-0">{{$total}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldBuy"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Pendientes</h6>
                                        <h6 class="font-extrabold mb-0">{{$cantidad_porcobrar->cantidad}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}


                    {{-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldUnlock"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Por cobrar</h6>
                                        <h6 class="font-extrabold mb-0">{{$monto_porcobrar->cantidad}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}


                </div>


                {{-- <div hidden class="col-12">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">

                                @if (isset($clientes) && count($clientes)>0)
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <select class=" choices cliente filtro" data-type="select-one" tabindex="0"
                                        role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                        aria-expanded="false">
                                        <option value="0" selected>Seleccione una opcion </option>
                                        @foreach ($clientes as $key=>$value)
                                            <option value="{{$key}}"> {{$value}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                @endif

                                @if (isset($empleados) && count($empleados)>0)
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Empleado</label>
                                        <select class=" choices empleado filtro" data-type="select-one" tabindex="0"
                                        role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                        aria-expanded="false">
                                        <option value="0" selected>Seleccione una opcion </option>
                                        @foreach ($empleados as $key=>$value)
                                            <option value="{{$key}}"> {{$value}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                @endif

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Estado de pago</label>
                                        <select class="form-select estadopago filtro" name="" id="">
                                            <option value="0" selected>Seleccione una opcion </option>
                                            <option value="1">Completo </option>
                                            <option value="2"> Pendiente </option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div> --}}

                {{-- <div class="col-12">
                    <div class="card">
                        
                        <div class="card-content">
                            
                            <div class="card-body tabla" id="tabla">
                                @include('ventas.index_data')
 
                            </div>

                        </div>
                    </div>
                </div> --}}


                <div class="col-12">
 
                    @if (isset($ventas) && count($ventas)>0)
                        @php
                            $total_venta  = count($ventas)
                        @endphp
                        @foreach ($ventas as $key=>$item)
                            <div class="card  pb-1 mb-1 shadow">
                                <div class="card-content  ">
                                    <div class="card-body  " >
                                        <label> <strong> #{{$total_venta - $key}} {{ trim($item->cliente ) ? ucfirst($item->cliente) : "Sin Nombre"}} - {{ $item->hora }} </strong></label>
                                        <div class="row">
                                            <input type="text" hidden class="id hidden" data-id="{{ $item->id }}">
                                            <div class="col-lg-4 pb-2">
                                                <div>
                                                    @php
                                                        $string ="<label>";
                                                        $string .= str_replace(",,",'</label><br><label>',$item->detalle);
                                                        $string .="</label>";

                                                        print_r($string);
                                                    @endphp
                                                </div>
                                            </div>
                                            <div class="col-lg-3 pb-2">
                                                <div>
                                                    <label for=""> <strong>Total a pagar: </strong></label>
                                                    <label for=""> {{ $item->monto }} </label>
                                                </div>
                                                <div>
                                                    <label for=""> <strong> Descuento: </strong></label>
                                                    <label for=""> {{ $item->descuento_importe }} </label>
                                                </div>
                                                <div>
                                                    <label for=""> <strong>Total recibido: </strong></label>
                                                    @if ( $item->total_recibido > $item->monto)
                                                        <span class="badge bg-success">{{ $item->total_recibido }}</span>
                                                    @elseif(   $item->total_recibido < $item->monto )
                                                        <span class="badge bg-danger">{{ $item->total_recibido }}</span>
                                                    @else 
                                                        {{ $item->total_recibido }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-3 pb-3">
                                                <div>
                                                    <label for=""> <strong> Estado del pedido:  </strong></label>
                                                    <label for=""> {{ $item->estadoenvio }} </label>
                                                </div>
                                                <div>
                                                    <label for=""> <strong> Metodo de pago: </strong></label>
                                                    <label for=""> {{ $item->tipo_pago }} </label>
                                                </div>
                                                <div>
                                                    <label for=""> <strong> Estado de pago: </strong></label>
                                                    @if ($item->pago_completo)
                                                        <span class="badge bg-success">Completo</span>
                                                    @else
                                                        <span class="badge bg-warning">Pendiente</span>
                                                    @endif
        
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                @if (isset($item->tipoenvio_id) && $item->tipoenvio_id ==2)
                                                    <label class="btn btn-info btn-sm mt-1 listado-enviado"  data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar como entregado" data-bs-original-title="Marcar como entregado" > <i class="bi bi-check-all"></i> Enviado </label>
                                                @endif
                                                <a  class="btn btn-success btn-sm mt-1  " href="{{url("ventas/edit",$item->id)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar"> <i class="bi bi-pencil"></i> Editar </a>
                                                @can("venta-destroy")
                                                <button class="btn btn-danger btn-sm mt-1 listado-eliminar " data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i> Eliminar</button>
                                                @endcan
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else

                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-content d-flex justify-content-center ">
                                <div class="col-6 col-lg-4 col-md-3 col-2 mb-4 mt-4 mx-4" data-tags="note card notecard">

                                    <div class="p-3 py-4 mb-2 bg-light text-center rounded">
                                        <svg class="" width="5em" height="5em" fill="currentColor">
                                            <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#card-heading"></use>
                                        </svg>
                                    </div>
                                    <div class="name text-muted text-decoration-none text-center pt-1">
                                        No se registraron ventas
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @endif
                   
 

                </div>


            </div>
        </section>








        {{-- <!--Basic Modal  detalles de venta--> --}}
        <div class="modal fade text-left" id="detalles-venta" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
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
    <script defer src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
    <script  src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>

    {{-- <script src="{{asset('assets/vendors/jquery/jquery.min.js')}}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}

      {{-- <script defer src="{{ asset('js/resources/ventas.index.js')}}"></script> --}}
      <script defer src="{{ asset('js/ventas.index.min.js')}}"></script>

 
@endsection
