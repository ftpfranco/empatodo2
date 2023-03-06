@extends('layouts.app')
@section('title')
    Cajas
@endsection
@section('styles')
    {{-- <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
<script src="{{asset('js/toastr.min.js')}}"></script> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')

    <div class="page-heading mx-3 mb-1 ">
        @role("administrador")
        <div class="mb-3 mt-0 boton-abrir-caja">
            @if (isset($caja_abierta) && count($caja_abierta)== 0)
            <button class="btn btn-outline-success btn-sm mx-1 " data-bs-toggle="modal" data-bs-target="#apertura-caja"> ABRIR </button>
            {{-- <button class="btn btn-outline-success btn-sm mx-1 registro-ingreso" data-bs-toggle="modal" data-bs-target="#ingreso-caja"> REGISTRAR INGRESO </button>
            <button class="btn btn-outline-success btn-sm mx-1 registro-egreso" data-bs-toggle="modal"  data-bs-target="#egreso-caja"> REGISTRAR EGRESO </button> --}}
            @endif
        </div>
        @endrole
        <div class=" d-flex justify-content-start">
            <h3> Operaciones de Caja </h3>
        </div>
    </div>


    <div class="page-content">

        {{-- <!-- Basic Vertical form layout section start --> --}}
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Fecha apertura</th>
                                                <th>Monto inicio</th>
                                                <th>Monto acumulado </th>
                                                {{-- <th>Ingresos</th>
                                                <th>Egresos</th> --}}
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="caja-abierta" id="caja-abierta">

                                            @if (isset($caja_abierta) && !empty($caja_abierta))
                                                @foreach ($caja_abierta as $item)
                                                    <tr>
                                                        <td hidden class="caja_id" data-id="{{ $item->id }}">
                                                            {{ $item->id }}</td>
                                                            <td class="caja_fecha">{{ $item->inicio_fecha }}
                                                                {{ $item->inicio_hora }}</td>
                                                                <td class="caja_montoinicio"
                                                                data-monto="{{ $item->monto_inicio }}">
                                                                {{ $item->monto_inicio }}</td>
                                                                <td class="caja_montoacumulado"
                                                                data-monto="{{ $item->monto_estimado }}">
                                                                {{ $item->monto_estimado }}</td>
                                                        {{-- <td>{{ $item->monto_estimado }}</td> --}}
                                                        {{-- <td>{{ $item->ingresos }}</td>
                                                        <td>{{ $item->egresos }}</td> --}}
                                                        <td>
                                                            <button class="btn btn-success btn-sm cerrar-caja">  Cerrar </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>

                                    </table>
                                </div>


                                
                                <div class="col-12" id="no-caja-abierta">
                                    @if  ( isset($caja_abierta) && count($caja_abierta) ==0)
                                    <div class="card">
                                        <div class="card-content d-flex justify-content-center ">
                                            <div class="col-6 col-lg-4 col-md-3 col-2 mb-4 mt-4 mx-4" data-tags="note card notecard">

                                                <div class="p-3 py-4 mb-2 bg-light text-center rounded">
                                                    <svg class="" width="5em" height="5em" fill="currentColor">
                                                        <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#folder2-open"></use>
                                                    </svg>
                                                </div>
                                                <div class="name text-muted text-decoration-none text-center pt-1">
                                                    Aqu&iacute; podr&aacute;s listar y administrar todas las cajas disponibles .
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                @if (!empty($historial))
                    {{-- filtros --}}
                    {{-- <div class="co-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Desde</label>
                                                <input type="date" class="form-control filtro filtro-desde"
                                                    placeholder="2020-10-10">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Hasta</label>
                                                <input type="date" class="form-control filtro filtro-hasta"
                                                    placeholder="2020-10-10">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                @endif


                {{-- @role("administrador") --}}
                {{-- listado --}}
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-content">
                            <div class="card-header d-flex justify-content-between">
                                <div class="col">
                                    <h4 class="card-title">Historial</h4>
                                </div>
                            </div>
                            <div class="card-body" id="tabla">

                                @include('cajas.index_data')
                            </div>


                        </div>
                    </div>
                </div>
 
                {{-- @endrole --}}

            </div>
        </section>








        {{-- <!--Basic Modal  apertura caja--> --}}
        <div class="modal fade text-left" id="apertura-caja" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11"> APERTURA DE CAJA </h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Fecha de apertura</label>
                                        <input type="date" id="fecha" class="form-control" name="fecha"
                                            placeholder="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Hora de apertura</label>
                                        <input type="time" id="hora" class="form-control" name="hora"
                                            placeholder="{{ date('H:i') }}" value="{{ date('H:i') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Monto inicial </label>
                                <input type="number" id="monto" class="form-control" name="monto" placeholder="" min="0"
                                    max="99999999">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                SALIR
                            </button>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary btn-block abrir-caja"  >
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- <!--Basic Modal cerrar caja --> --}}
        <div class="modal fade text-left" id="cerrar-caja" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel1"> CIERRE DE CAJA</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="">Fecha de cierre</label>
                                    <input type="date" class="form-control cerrar-fecha" value="{{ date('Y-m-d') }}"
                                        placeholder="2020-10-10 10:10">
                                </div>

                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="">Hora de cierre</label>
                                    <input type="time" class="form-control cerrar-hora" value="{{ date('H:i') }}"
                                        placeholder="2020-10-10 10:10">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label> Turno de cierre </label>
                                <select class="form-select cierre-caja-turno" name="" id="">
                                    <option value="-1" selected>Seleccione una opcion</option>
                                    <option value="1"> Cierre parcial Turno Mañana </option>
                                    <option value="2"> Cierre parcial Turno Tarde </option>
                                    <option value="3"> Cierre parcial Turno Noche </option>
                                    <option value="4"> Cierre total</option>
                                </select>
                            </div>
                        </div>
                                

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Monto inicio</label>
                                    <input type="text" class="form-control cerrar-monto-inicio" placeholder="" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Monto Total</label>
                                    <input type="text" class="form-control cerrar-monto-total" placeholder="" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Monto real</label>
                            <input type="number" name="cerrar-monto-real" class="form-control cerrar-monto-real"
                                placeholder="">
                        </div>

                         
                        {{-- <div class="form-group">
                            <label>Comentario </label>
                            <textarea id="comentario" class="form-control comentario"
                                name="comentario" placeholder=""></textarea>
                        </div> --}}

                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                SALIR
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block  modal-cerrar-caja">
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- <!--Basic Modal  ingreso caja-->
        <div class="modal fade text-left" id="ingreso-caja" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel121" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel121">Nuevo ingreso a caja</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group">
                                <label>Importe </label>
                                <input type="number" id="first-name" class="form-control ingreso-importe"
                                    name="ingreso-importe" placeholder="">
                            </div>

                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success btn-block registro-ingreso-guardar" >
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}




        {{-- <!--Basic Modal  egreso caja-->
        <div class="modal fade text-left" id="egreso-caja" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1212" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1212">Nuevo egreso a caja</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group">
                                <label>Importe </label>
                                <input type="number" id="first-name" class="form-control egreso-importe" placeholder="">
                            </div>

                             
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success btn-block registro-egreso-guardar" >
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>


@endsection
@section('scripts')
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    <script defer src="{{ asset('js/resources/cajas_.js')}}"></script>
    {{-- <script defer src="{{ asset('js/cajas.min.js')}}"></script> --}}

@endsection
