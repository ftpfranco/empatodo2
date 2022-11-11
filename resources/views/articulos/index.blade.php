@extends('layouts.app')
@section('title')
    Articulos - Listado
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

@endsection

@section('content')


    <div class="page-heading mx-3 mb-1 ">
        @role("administrador")
        <div class="mb-3 mt-0">
            <button class="btn btn-outline-success mt-1" data-bs-toggle="modal" data-bs-target="#nuevo-articulo"><strong>+</strong>NUEVO</button>
            <a class="btn btn-outline-success mt-1" href="{{url("categorias")}}" > CATEGORIA DE ARTICULOS</a>
        </div>
        @endrole
        <div class=" d-flex justify-content-start">
            <h3>Articulos</h3>
        </div>
    </div>


    <div class="page-content">

        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0" id="table-hover-row">


                {{-- <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    


                                    @if (isset($categorias) && count($categorias) > 0)
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Categoria</label>
                                                <select class=" choices cliente filtro filtro-categoria"
                                                    data-type="select-one" tabindex="0" role="combobox"
                                                    aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                                    <option value="0" selected>Seleccione una opcion</option>
                                                    @foreach ($categorias as $key => $item)
                                                        <option value="{{ $key }}">
                                                            {{ $item }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif


                                    @if (isset($marcas) && count($marcas) > 0)
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Marca</label>
                                                <select class=" choices filtro filtro-marca" data-type="select-one"
                                                    tabindex="0" role="combobox" aria-autocomplete="list"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <option value="0" selected>Seleccione una opcion</option>
                                                    @foreach ($marcas as $key => $item)
                                                        <option value="{{ $key }}">{{ $item }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Estado</label>
                                            <select class="form-select filtro filtro-habilitado" name="" id="">
                                                <option value="0" selected>Seleccione una opcion</option>
                                                <option value="1">Habilitado</option>
                                                <option value="2">No habilitado</option>

                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div> --}}


                <div class=" col-12">
                    <div class="card shadow">
                        <div class="card-content">
                            <div class="card-body" id="tabla">

                                @include('articulos.index_data')
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>




        {{-- <!-- Basic Modal  nuevo articulo--> --}}
        <div class="modal fade text-left" id="nuevo-articulo" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">AGREGAR NUEVO ARTICULO</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            {{-- @if (isset($marcas) && count($marcas) > 0)
                                <div class="form-group">
                                    <label for="">Marca</label>
                                    <select class=" choices  producto-marca" data-type="select-one" tabindex="0"
                                        role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                        <option value="0" selected>Seleccione una opcion</option>
                                        @foreach ($marcas as $key => $item)
                                            <option value="{{ $key }}">{{ $item }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif --}}

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nombre <span style="color:red">*</span></label>
                                    <input type="text" class="form-control producto-nombre" placeholder="" value="">
                                </div>
                           </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Descripcion <span style="color:red">*</span></label>
                                    <input type="text" class="form-control nombre_corto" placeholder="" value="">
                                </div>
                            </div>

                           <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input type="text" class="form-control producto-codigo" placeholder="">
                                </div>
                           </div>
                          
                            @if (isset($categorias) && count($categorias) > 0)
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="producto-categoria">Categoria</label>
                                    {{-- <select class=" choices modal-editar-categoria"
                                        data-type="select-one" tabindex="0" role="combobox"
                                        aria-autocomplete="list" aria-haspopup="true" aria-expanded="false"> --}}
                                    <select class=" form-select  producto-categoria" id="producto-categoria">
                                        <option value="-1" selected>Seleccione una opcion</option>
                                        @foreach ($categorias as $key => $item)
                                            <option value="{{ $key }}">  {{ $item }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Precio costo</label>
                                    <input type="number" class="form-control producto-preciocosto" placeholder="">
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Precio venta</label>
                                    <input type="number" class="form-control producto-precioventa" placeholder="">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" class="form-control producto-stock" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Stock minimo</label>
                                    <input type="number" class="form-control producto-stockminimo" placeholder="">
                                </div>
                            </div>

                            {{-- <div class="col-12 mt-1 ">
                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" checked
                                            class="form-check-input form-check-primary form-check-glow producto-habilitado"
                                            name="customCheck1" id="customColorCheck1_">
                                        <label class="form-check-label" for="customColorCheck1_">Habilitar articulo</label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="py-4">
                                <small>(<span style="color:red">*</span>) estos datos son obligatorios</small>
                            </div>


                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                        SALIR
                                    </button>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <button type="button" class="btn btn-primary btn-block producto-guardar disabled" disabled>
                                        GUARDAR
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        {{-- <!-- Basic Modal  editar articulo--> --}}
        <div class="modal fade text-left" id="editar-articulo" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel12" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel12">EDITAR ARTICULO</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            {{-- @if (isset($marcas) && count($marcas) > 0)
                                <div class="form-group">
                                    <label for="">Marca</label>
                                    <select class="  form-control modal-editar-marca">
                                        <option value="0" selected>Seleccione una opcion</option>
                                        @foreach ($marcas as $key => $item)
                                            <option value="{{ $key }}">{{ $item }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif --}}

                           <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nombre <span style="color:red">*</span></label>
                                    <input type="text" class="form-control modal-editar-articulo" placeholder="" value="">
                                </div>
                           </div>

                           <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Descripcion <span style="color:red">*</span></label>
                                    <input type="text" class="form-control modal-editar-nombre_corto" placeholder="" value="">
                                </div>
                            </div>
                            <input class="modal-editar-id" hidden type="text">


                           <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <input type="text" class="form-control modal-editar-codigo" placeholder="">
                                </div>
                           </div>

                            @if (isset($categorias) && count($categorias) > 0)
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Categoria</label>
                                        {{-- <select class=" choices modal-editar-categoria"
                                            data-type="select-one" tabindex="0" role="combobox"
                                            aria-autocomplete="list" aria-haspopup="true" aria-expanded="false"> --}}
                                        <select class=" form-control  modal-editar-categoria" id="modal-editar-categoria" >
                                            <option value="-1" selected>Seleccione una opcion</option>
                                            @foreach ($categorias as $key => $item)
                                                <option value="{{ $key }}">
                                                    {{ $item }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Precio costo</label>
                                    <input type="number" class="form-control modal-editar-preciocompra" placeholder="">
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Precio venta</label>
                                    <input type="number" class="form-control modal-editar-precioventa" placeholder="">
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" class="form-control modal-editar-stock" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Stock minimo</label>
                                    <input type="number" class="form-control modal-editar-stockminimo" placeholder="">
                                </div>
                            </div>

                            {{-- <div class="col-12 mt-1 ">
                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                            class="form-check-input form-check-primary form-check-glow modal-editar-habilitado"
                                            name="customCheckw" id="customColorCheck4">
                                        <label class="form-check-label" for="customColorCheck4">Habilitar articulo</label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="py-4">
                                <small>(<span style="color:red">*</span>) estos datos son obligatorios</small>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                SALIR
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block editar-producto-guardar disabled" disabled>
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        {{-- <!-- Basic Modal  editar stock--> --}}
        <div class="modal fade text-left" id="modal-stock" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel13" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title titulo" id="myModalLabel13" >  </h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div>

                            <input class="modal-stock-id" hidden type="text">

                            <div class="col">
                                <div class="form-group">
                                    <label>Stock actual</label>
                                    <input type="number" disabled class="form-control modal-stock-actual" placeholder="">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Cantidad a incrementar </label>
                                    <input type="number" class="form-control modal-stock-stock" placeholder=""  min="1" max="99999">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                SALIR
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block modal-stock-guardar disabled" disabled>
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection

@section('scripts')
    <script  src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}


    {{-- <script defer src="{{asset('js/resources/articulos.listado.js')}}"></script> --}}
    <script defer src="{{asset('js/articulos.listado.min.js')}}"></script>

     
@endsection
