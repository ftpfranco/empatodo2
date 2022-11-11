@extends('layouts.app')
@section('title')
    Empleados
@endsection
@section('styles')


    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection

@section('content')

    {{-- <div class="page-heading mx-3">
        <div class=" d-flex justify-content-start">
            <h3>Empleados</h3>
            <div>
                <button class="btn btn-outline-success mx-2 abrir-modal-nuevo">
                    Nuevo</button>
            </div>
        </div>
    </div> --}}

    <div class="page-heading mx-3 mb-1">
        <div class="mb-3 mt-0">
            {{-- <button class="btn btn-outline-success mx-1 mt-1 " data-bs-toggle="modal" data-bs-target="#ingreso-nuevo"> + Nuevo 
            </button>  --}}
            <button class="btn btn-sm btn-outline-success mx-2 abrir-modal-nuevo"><strong>+</strong>AGREGAR EMPLEADO</button>
        </div>
        <div class="d-flex justify-content-start">
            <h3> Empleados </h3>
        </div>
    </div>


    <div class="page-content">

        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">
                <div class=" col">
                    <div class="card shadow">

                        <div class="card-content">
                            <div class="card-body" id="tabla">
                                @include('empleados.index_data')
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!--Basic Modal  nuevo-empleado -->
        <div class="modal fade text-left" id="nuevo-empleado" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel13" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel13">AGREGAR NUEVO EMPLEADO</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="">
                            {{-- <div class="divider">
                                <div class="divider-text">Datos de acceso</div>
                            </div> --}}
                            <div class="row">
                                <h4>Configuracion de acceso</h4>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Mail <span class="" style="color:red">*</span></label>
                                        <input type="email" class="form-control modal-nuevo-email" placeholder=""
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Contraseña <span class="" style="color:red">*</span></label>
                                        <input type="password" class="form-control modal-nuevo-password"
                                            placeholder="**********" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <br>

                            <h4>Turno laboral <span class="" style="color:red">*</span></h4>
                            <div class="row">
                                <div class="col-12">
                                    <label>Turno Mañana </label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Hora de Incio</label>
                                                <input type="time" class="form-control t1-start "  >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Hora de Fin</label>
                                                <input type="time" class="form-control t1-end "  >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label>Turno Tarde </label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Hora de Incio</label>
                                                <input type="time" class="form-control  t2-start"  >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Hora de Fin</label>
                                                <input type="time" class="form-control  t2-end"   >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 
                            </div>
                            <br>
 
                            <h4>Datos personales</h4>
                            <div class="row">
                                <div class="col ">
                                    <div class="form-group">
                                        <label>Nombre / Razon social <span class="" style="color:red">*</span></label>
                                        <input type="text" class="form-control modal-nuevo-nombre" placeholder="">
                                    </div>
                                </div>
                               
                            </div>

                            <div class="row">
                                {{-- <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de identificacion</label>
                                        <select class="form-select modal-nuevo-identificacion" name="" id="">
                                            <option value="0" selected>Seleccione una opcion</option>
                                            @if (isset($tipoidentificacion) && !empty($tipoidentificacion))
                                                @foreach ($tipoidentificacion as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}
                                
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Dni/Cuil</label>
                                        <input type="text" class="form-control modal-nuevo-nroidentificacion"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Telefono</label>
                                        <input type="text" class="form-control modal-nuevo-telefono" placeholder="">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Direccion</label>
                                        <input type="text" class="form-control modal-nuevo-direccion" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Localidad</label>
                                        <input type="text" class="form-control modal-nuevo-localidad" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" checked
                                            class="form-check-input form-check-primary form-check-glow modal-nuevo-habilitado"
                                            name="customCheck" id="customColorCheck1">
                                        <label class="form-check-label" for="customColorCheck1"> Habilitado</label>
                                    </div>
                                </div>
                            </div>

                            <div class="py-4">
                                <small>(<span class="" style="color:red">*</span>) Estos datos son obligatorios</small>
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
                            <button type="button" class="btn btn-primary btn-block modal-nuevo-guardar">
                                GUARDAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Basic Modal  editar-empleado -->
        <div class="modal fade text-left" id="editar-empleado" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">EDITAR EMPLEADO</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">

                            {{-- <div class="divider">
                                <div class="divider-text">Datos de acceso</div>
                            </div> --}}
                            <h4>Configuracion de acceso</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Mail  <span class="" style="color:red">*</span></label>
                                        <input type="email" class="form-control modal-editar-email" placeholder=""
                                            autocomplete=”off”>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Contraseña </label>
                                        <input type="password" class="form-control modal-editar-password"
                                            placeholder="**********" autocomplete=”off”>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <h4>Turno laboral <span class="" style="color:red">*</span></h4>
                            <div class="row">
                                <div class="col-12">
                                    <label>Turno Mañana </label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Hora de Incio</label>
                                                <input type="time" class="form-control t1-start "  >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Hora de Fin</label>
                                                <input type="time" class="form-control t1-end "  >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label>Turno Tarde </label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Hora de Incio</label>
                                                <input type="time" class="form-control  t2-start"  >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Hora de Fin</label>
                                                <input type="time" class="form-control  t2-end"   >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 
                            </div>
                            <br>
 
                            <h4>Datos personales</h4>
                            <input class="modal-editar-id" type="text" hidden>
                            <div class="row">
                                <div class="col ">
                                    <div class="form-group">
                                        <label>Nombre / Razon social <span class="" style="color:red">*</span></label>
                                        <input type="text" class="form-control modal-editar-nombre" placeholder="">
                                    </div>
                                </div>

                               
                            </div>

                            <div class="row">
                                {{-- <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de identificacion</label>
                                        <select class="form-select modal-editar-tipoidentificacion" name="" id="">
                                            <option value="0" selected>Seleccione una opcion</option>
                                            @if (isset($tipoidentificacion) && !empty($tipoidentificacion))
                                                @foreach ($tipoidentificacion as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Dni/Cuil</label>
                                        <input type="text" class="form-control modal-editar-dni" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Telefono</label>
                                        <input type="text" class="form-control modal-editar-telefono" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Direccion</label>
                                        <input type="text" class="form-control modal-editar-direccion" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Localidad</label>
                                        <input type="text" class="form-control modal-editar-localidad" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                            class="form-check-input form-check-primary form-check-glow modal-editar-habilitado"
                                            name="customCheck" id="customColorCheck4">
                                        <label class="form-check-label" for="customColorCheck4"> Habilitado</label>
                                    </div>
                                </div>
                            </div>

                            <div class="py-4">
                                <small>(<span class="" style="color:red">*</span>) Estos datos son obligatorios</small>
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
                            <button type="button" class="btn btn-primary btn-block modal-editar-guardar"
                                data-bs-dismiss="modal">
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

    {{-- <script defer src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    {{-- <script defer src="{{ asset('js/resources/empleados.js')}}"></script> --}}
    <script defer src="{{ asset('js/empleados.min.js')}}"></script>
 
@endsection
