@extends('layouts.app')
@section('title')
    Ingresos
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

@endsection
@section('content')

    {{-- <div class="page-heading mx-3">
        <div class=" d-flex justify-content-start">
            <h3> Ingresos </h3>
            <div class="mx-1">
                <button class="btn btn-outline-success   " data-bs-toggle="modal" data-bs-target="#ingreso-nuevo"> + Nuevo 
                </button> 
                <a class="btn btn-outline-success mx-2 " href="{{url('ingresostipos')}}" > Categorias de ingresos</a>
            </div>
        </div> 
    </div> --}}


    <div class="page-heading mx-3 mb-1">
        <div class="mb-3 mt-0">
            <button class="btn btn-sm btn-outline-success mx-1 mt-1 " data-bs-toggle="modal" data-bs-target="#ingreso-nuevo"> <strong>+</strong>NUEVO 
            </button> 
            <a class="btn btn-sm btn-outline-success  mx-1 mt-1" href="{{url('ingresostipos')}}" >CATEGORIA DE INGRESOS</a>
        </div>
        <div class="d-flex justify-content-start">
            <h3> Ingresos </h3>
        </div>
    </div>
    <div class="page-content">


        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="row  m-0 p-0 ">

                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldPaper"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Ingresos</h6>
                                        <h6 class="font-extrabold mb-0 resumen-cantidad">{{ isset($sumaingresos['cantidad'])?$sumaingresos['cantidad']:0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card mb-1 shadow">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="stats-icon blue">
                                            <i class=" iconly-boldChart"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="text-muted font-semibold">Total</h6>
                                        <h6 class="font-extrabold mb-0 ingresos resumen-total"
                                            data-monto="{{ isset($sumaingresos['total'])?$sumaingresos['total']:0 }}"> {{ isset($sumaingresos['total'])?$sumaingresos['total']:0 }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- <!-- filtros --> --}}
                <div class="col-12">
                    <div class="card mb-1 shadow">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Desde</label>
                                            <input type="date" class="form-control filtro filtro-fechadesde"
                                                placeholder="2020-10-10">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Hasta</label>
                                            <input type="date" class="form-control filtro filtro-fechahasta"
                                                placeholder="2020-10-10">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Categoria de ingreso</label>
                                            <select class="form-select filtro filtro-tipoingreso" name="" id="">
                                                <option value="0" selected> Todos </option>
                                                @if (isset($tipoingreso) && !empty($tipoingreso))
                                                    @foreach ($tipoingreso as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>





                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-content">
                            {{-- <div class="card-header d-flex justify-content-between">
                                <div class="col">
                                    <h4 class="card-title">Listado de ingresos</h4>
                                </div>
                            </div> --}}

                            <div class="card-body">
                                <div class="table-responsive mt-4" id="tabla">
                                    @include('ingresos.index_data')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>





        </section>


        {{-- <!--Basic Modal  Nuevo ingreso--> --}}
        <div class="modal fade text-left" id="ingreso-nuevo" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">NUEVO INGRESO</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Fecha</label>
                                    <input type="date" id="first-name-vertical" class="form-control modal-ingreso-fecha"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Categoria de ingreso</label>
                                    <select class="form-select modal-ingreso-tipoingreso" name="" id="">
                                        <option value="-1" selected> Selecciona una opcion </option>
                                        @if (isset($tipoingreso) && !empty($tipoingreso))
                                            @foreach ($tipoingreso as $key => $value)
                                                <option value="{{ $key }}">{{ $value }} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Monto</label>
                                    <input type="number"  class="form-control modal-ingreso-monto"
                                        placeholder="">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="email-id-vertical">Comentario</label>
                                <textarea type="textarea" id="email-id-vertical"
                                    class="form-control modal-ingreso-comentario" name="email-id" placeholder=""></textarea>
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
                            <button type="button" class="btn btn-primary btn-block modal-ingreso-guardar" disabled>
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        {{-- <!--Basic Modal  editar ingreso--> --}}
        <div class="modal fade text-left" id="ingreso-editar" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel12" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel12">EDITAR INGRESO</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Fecha</label>
                                    <input type="date" id="first-name-vertical"
                                        class="form-control modal-ingreso-editar-fecha" value=" ">
                                </div>
                                <input class="modal-ingreso-editar-id" hidden type="text">
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Categora de ingreso</label>
                                    <select class="form-select modal-ingreso-editar-ingresotipo" >
                                        <option value="-1" selected> Selecciona una opcion </option>
                                        @if (isset($tipoingreso) && !empty($tipoingreso))
                                            @foreach ($tipoingreso as $key => $value)
                                                <option value="{{ $key }}">{{ $value }} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Monto</label>
                                    <input type="number"  class="form-control modal-ingreso-editar-monto"
                                        placeholder="">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="email-id-vertical">Comentario</label>
                                <textarea type="textarea" id="email-id-vertical"
                                    class="form-control modal-ingreso-editar-comentario" name="email-id"
                                    placeholder=""></textarea>
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
                            <button type="button" class="btn btn-primary btn-block modal-ingreso-editar-guardar" disabled>
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>







        {{-- <!--Basic Modal  tipo nuevo--> --}}
        <div class="modal fade text-left" id="tipo-nuevo" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">NUEVA CATEGORIA DE INGRESO</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col ">
                            <div class="form-group">
                                <label for="">Nombre de la categoria</label>
                                <input type="text" class="form-control tipoingreso">
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
                            <button type="button" class="btn btn-primary btn-block tipoingreso-nuevo" disabled>
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
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}

    {{-- <script defer src="{{ asset('js/resources/ingresos.js')}}"></script> --}}
    <script defer src="{{ asset('js/ingresos.min.js')}}"></script>
 
@endsection
