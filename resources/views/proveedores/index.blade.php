@extends('layouts.app')
@section('title')
    Proveedores
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')

    <div class="page-heading mx-3">
        <div class="d-flex justify-content-start">
            <h3>Proveedores</h3>
            <div>
                <button class="btn btn-outline-success mx-2" data-bs-toggle="modal"
                    data-bs-target="#nuevo-proveedor">Nuevo</button>
                {{-- <a class="btn btn-outline-success mx-2" href="_proveedores.nuevo.php">Nuevo</a> --}}
            </div>
        </div>
    </div>
    <div class="page-content">

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="row m-0 p-0">
                    <div class="col">
                        <div class="card">
                            <div class="card-content">

                                <div class="card-body" id="tabla">
                                    @include('proveedores.index_data')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!--Basic Modal  nuevo proveedor-->
        <div class="modal fade text-left" id="nuevo-proveedor" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">Nuevo proveedor</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nombre *</label>
                                    <input type="text"  class="form-control proveedor-nombre" 
                                        placeholder="">
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Tipo de identificacion</label>
                                    <select class="form-select proveedor-identificacion" name="" id="">
                                        <option value="-1">Seleccione una opcion</option>
                                        @if (isset($tipoidentificacion) && !empty($tipoidentificacion))
                                            @foreach ($tipoidentificacion as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label></label>
                                    <input type="text"  class="form-control proveedor-nroidentificacion"
                                            placeholder="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Mail</label>
                                    <input type="text"  class="form-control proveedor-email" 
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text"  class="form-control proveedor-telefono"
                                            placeholder="">
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input type="text"  class="form-control proveedor-direccion" 
                                        placeholder="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Localidad</label>
                                    <input type="text"  class="form-control proveedor-localidad" 
                                        placeholder="">
                                </div>
                            </div>

                            {{-- <div class="col-12 mt-4">
                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                            class="form-check-input form-check-primary form-check-glow proveedor-habilitado"
                                            checked="checked" name="customCheck" id="customColorCheck1">
                                        <label class="form-check-label" for="customColorCheck1"> Proveedor
                                            habilitado</label>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                        <div class="mt-2">
                            <small>(*) estos datos son obligatorios</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block proveedor-guardar disabled" disabled>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <!--Basic Modal  editar proveedor-->
        <div class="modal fade text-left" id="editar-proveedor" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">Editar proveedor</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input class="modal-editar-id" hidden type="text">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nombre *</label>
                                    <input type="text"  class="form-control modal-editar-nombre" 
                                        placeholder="">
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Tipo de identificacion</label>
                                    <select class="form-select modal-editar-tipoidentificacion" name="" id="">
                                        <option value="-1">Seleccione una opcion</option>
                                        @if (isset($tipoidentificacion) && !empty($tipoidentificacion))
                                            @foreach ($tipoidentificacion as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label></label>
                                    <input type="text"  class="form-control modal-editar-dni"  placeholder="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Mail</label>
                                    <input type="text"  class="form-control modal-editar-email"  placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text"  class="form-control modal-editar-telefono"   placeholder="">
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input type="text"  class="form-control modal-editar-direccion"
                                         placeholder="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Localidad</label>
                                    <input type="text"  class="form-control modal-editar-localidad"
                                         placeholder="">
                                </div>
                            </div>

                            {{-- <div class="col-12 mt-4">
                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                            class="form-check-input form-check-primary form-check-glow modal-editar-habilitado"
                                            checked="checked" name="customCheck" id="customColorCheck2">
                                        <label class="form-check-label" for="customColorCheck2"> Proveedor
                                            habilitado</label>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                        <div class="mt-2">
                            <small>(*) estos datos son obligatorios</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block modal-editar-guardar disabled" disabled >
                                Guardar
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

    <script defer src="{{ asset('js/resources/proveedores.js')}}"></script>
    {{-- <script src="{{ asset('js/proveedores.min.js')}}"></script> --}}
    
@endsection
