@extends('layouts.app')
@section('title')
    Compras
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')


    <div class="page-heading">
        <div class=" d-flex justify-content-start mx-3">
            <h3>Compras</h3>
            <div>
                <a class="btn btn-outline-success mx-2 " href="{{ url('compras/nuevo') }}">Nuevo</a>
            </div>
        </div>
    </div>
    <div class="page-content">

        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="row m-0 p-0">

                    <div class=" col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Compras</h6>
                                        <h6 class="font-extrabold mb-0">{{ isset($cantidad->cantidad)?$cantidad->cantidad:0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class=" col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Monto($)</h6>
                                        <h6 class="font-extrabold mb-0">{{ isset($monto->cantidad)?$monto->cantidad:0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>


                {{-- <!-- filtros --> --}}
                {{-- <div class="col">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Desde</label>
                                        <input type="date" class="form-control fecha_desde filtro" placeholder="2020-10-10">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Hasta</label>
                                        <input type="date" class="form-control fecha_hasta filtro" placeholder="2020-10-10">
                                    </div>
                                </div>


                                @if (isset($proveedores) && !empty($proveedores))
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Proveedor</label>
                                            <select class=" choices proveedor filtro" data-type="select-one" tabindex="0"
                                                role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                                aria-expanded="false">
                                                <option value="0" selected>Seleccione una opcion </option>
                                                @foreach ($proveedores as $key => $value)
                                                    <option value="{{ $key }}"> {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif


                                @if (isset($vendedores) && !empty($vendedores))
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Empleado</label>
                                            <select class=" choices empleado filtro" data-type="select-one" tabindex="0"
                                                role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                                aria-expanded="false">
                                                <option value="0" selected>Empleado 1 </option>
                                                @foreach ($vendedores as $key => $value)
                                                    <option value="{{ $key }}"> {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif


                                <div class="col-lg-4">
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

                <div class="row m-0 p-0">
                    <div class="col">
                        <div class="card">
                            {{-- <div class="card-header d-flex justify-content-between">
                                <div class="col">
                                    <h4 class="card-title">Listado de ventas</h4>
                                </div>
                            </div> --}}


                            <div class="card-content">
                                <div class="card-body tabla" id="tabla">
                                    @include('compras.index_data')
                                </div>


                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </section>








        <div class="modal fade text-left" id="detalles-compra" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel11">Detalle de compra</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body modal-detalles">

                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>



    </div>


@endsection




@section('scripts')
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}

    {{-- <script defer src="{{ asset('js/resources/compras.js')}}"></script> --}}
    <script defer src="{{ asset('js/compras.min.js')}}"></script>
 
@endsection
