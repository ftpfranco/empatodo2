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

    <div class="page-heading d-flex justify-content-start mx-3">
        <h3>Caja</h3>
        <div class="mx-1">
            <button class="btn btn-outline-success btn-sm mx-1 " data-bs-toggle="modal"
                data-bs-target="#apertura-caja">Abrir</button>
            <button class="btn btn-outline-success btn-sm mx-1 registro-ingreso" data-bs-toggle="modal"
                data-bs-target="#ingreso-caja">Ingreso
            </button>
            <button class="btn btn-outline-success btn-sm mx-1 registro-egreso" data-bs-toggle="modal"
                data-bs-target="#egreso-caja">Egreso</button>
        </div>
    </div>

    <div class="page-content">

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <!-- tabla -->
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Fecha apertura</th>
                                                <th>Monto inicio</th>
                                                <th>Monto estimado</th>
                                                <th>Ingresos</th>
                                                <th>Egresos</th>
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
                                                        <td>{{ $item->monto_estimado }}</td>
                                                        <td>{{ $item->ingresos }}</td>
                                                        <td>{{ $item->egresos }}</td>
                                                        <td>
                                                            <button class="btn btn-success btn-sm cerrar-caja">
                                                                Cerrar</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>

                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                @if (!empty($historial))
                    {{-- filtros --}}
                    <div class="co-12">
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
                    </div>
                @endif

                {{-- listado --}}
                <div class="col-12">
                    <div class="card">
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

            </div>
        </section>








        <!--Basic Modal  apertura caja-->
        <div class="modal fade text-left" id="apertura-caja" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel11">Nuevo apertura caja</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Fecha apertura</label>
                                        <input type="date" id="fecha" class="form-control" name="fecha"
                                            placeholder="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Hora apertura</label>
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
                            <button class="btn btn-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button class="btn btn-success btn-block abrir-caja"  >
                                Abrir caja
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Basic Modal cerrar caja -->
        <div class="modal fade text-left" id="cerrar-caja" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Cerrar caja</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="">Fecha cierre</label>
                                    <input type="date" class="form-control cerrar-fecha" value="{{ date('Y-m-d') }}"
                                        placeholder="2020-10-10 10:10">
                                </div>

                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="">Hora cierre</label>
                                    <input type="time" class="form-control cerrar-hora" value="{{ date('H:i') }}"
                                        placeholder="2020-10-10 10:10">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Monto inicio</label>
                            <input type="text" class="form-control cerrar-monto-inicio" placeholder="" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Monto real</label>
                            <input type="number" name="cerrar-monto-real" class="form-control cerrar-monto-real"
                                placeholder="">
                        </div>

                        {{-- <div class="form-group">
                        <label for="">Diferencia</label>
                        <input  type="number" name="cerrar-diferencia" class="form-control" placeholder="112" disabled>
                    </div> --}}



                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success btn-block  modal-cerrar-caja">
                                Cerrar caja
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!--Basic Modal  ingreso caja-->
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

                            {{-- <div class="form-group">
                                <label>Comentario </label>
                                <textarea id="ingreso-comentario" class="form-control ingreso-comentario"
                                    name="ingreso-comentario" placeholder=""></textarea>
                            </div> --}}
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
        </div>




        <!--Basic Modal  egreso caja-->
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

                            {{-- <div class="form-group">
                                <label>Comentario </label>
                                <textarea id="first-name" class="form-control egreso-comentario"
                                    placeholder=""> </textarea>
                            </div> --}}
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
        </div>

    </div>


@endsection
@section('scripts')
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    <script>
        $(document).ready(function() {

            // abrir caja
            $(document).on("click", ".abrir-caja", function() {
                var fecha = $("#fecha").val();
                var hora = $("#hora").val();
                var monto = $("#monto").val();
                var url = window.location.origin + window.location.pathname + "/abrir";

                var data = {
                    fecha: fecha,
                    hora: hora,
                    monto: monto
                }

                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.data) {
                            var tr = `
                                <tr>
                                    <td hidden  class="caja_id"> ${response.data.id} </td>
                                    <td class="caja_fecha"> ${response.data.inicio_fecha} ${response.data.inicio_hora}</td>
                                    <td class="caja_montoinicio" data-monto="${response.data.monto_inicio} ">  ${response.data.monto_inicio}  </td>
                                    <td> ${response.data.monto_estimado}  </td>
                                    <td> ${response.data.ingresos}  </td>
                                    <td> ${response.data.egresos}  </td>
                                    <td>
                                        <button class="btn btn-success btn-sm cerrar-caja" > Cerrar</button>
                                    </td>
                                </tr>
                            `;
                            $(".caja-abierta").html(tr);
                            $("#apertura-caja").modal("hide")
                        }
                        if (response.errors) {
                            response.errors.forEach(element => {
                                console.log(element)
                                Toastify({
                                    text: element,
                                    duration: 3000,
                                    close: true,
                                    //backgroundColor: "#4fbe87"
                                }).showToast();
                            })
                        }
                        if (response.message) {
                            Toastify({
                                text: response.message,
                                duration: 3000,
                                close: true,
                                //backgroundColor: "#4fbe87"
                            }).showToast();

                        }
                    },
                    error: function(response) {
                        console.log(response)

                    }

                });
            }); // 

            // boton cerrar caja
            $(document).on("click", ".cerrar-caja", function() {
                var montoinicio = $(this).parent().parent().find('.caja_montoinicio').attr("data-monto");
                console.log(montoinicio)
                $(".cerrar-monto-inicio").val(montoinicio);
                $("#cerrar-caja").modal("show");
            });

            // modal boton  cerrar caja
            $(document).on("click", ".modal-cerrar-caja", function() {
                var monto_real = $('.cerrar-monto-real').val();
                var fecha = $(".cerrar-fecha").val();
                var hora = $(".cerrar-hora").val();
                var url = window.location.origin + window.location.pathname + "/cerrar";

                data = {
                    monto_real: monto_real,
                    fecha: fecha,
                    hora: hora
                }

                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.status == "success") {
                            $(".caja-abierta").html('');
                        }

                        if (response.data) {
                            var diferencia =
                                `<span class="badge bg-success"> ${response.data.diferencia?response.data.diferencia:''}  </span>`;
                            if (response.data.diferencia < 0) {
                                diferencia =
                                    `<span class="badge bg-danger"> ${response.data.diferencia?response.data.diferencia:''}  </span>`;
                            }
                            var tr = `
                                <tr>
                                    <td hidden class="caja_id"> ${response.data.id?response.data.id:''} </td>
                                    <td> ${response.data.inicio_fecha?response.data.inicio_fecha:''} ${response.data.inicio_hora?response.data.inicio_hora:''}</td>
                                    <td> ${response.data.cierre_fecha?response.data.cierre_fecha:''} ${response.data.cierre_hora?response.data.cierre_hora:''}</td>
                                    <td>  ${response.data.monto_inicio?response.data.monto_inicio:''}  </td>
                                    <td> ${response.data.monto_estimado?response.data.monto_estimado:''} </td>
                                    <td> ${response.data.ingresos?response.data.ingresos:''} </td>
                                    <td> ${response.data.egresos?response.data.egresos:''} </td>
                                    <td> ${response.data.monto_real?response.data.monto_real:''} </td>
                                    <td> ${diferencia} </td>
                                </tr>
                            `;
                            $(".historial").prepend(tr);
                            $("#cerrar-caja").modal("hide");

                        }
                        if (response.errors) {
                            response.errors.forEach(element => {
                                console.log(element)
                                Toastify({
                                    text: element,
                                    duration: 3000,
                                    close: true,
                                    //backgroundColor: "#4fbe87"
                                }).showToast();
                            })
                        }
                        if (response.message) {
                            Toastify({
                                text: response.message,
                                duration: 3000,
                                close: true,
                                //backgroundColor: "#4fbe87"
                            }).showToast();

                        }
                    },
                    error: function(response) {
                        console.log(response)
                        Toastify({
                            text: JSON.parse(response.responseText).message,
                            duration: 3000,
                            close: true,
                            //backgroundColor: "#4fbe87"
                        }).showToast();
                    }

                }); //


            }); //


            $(document).on("click", ".registro-ingreso-guardar", function() {
                var url = window.location.origin + window.location.pathname + "/ingreso";
                var importe = $(".ingreso-importe").val();
                var comentario = $.trim($(".ingreso-comentario").val());

                // validaciones
                // end validaciones

                var data = {
                    importe: importe,
                    comentario: comentario
                }
                console.log(data)

                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)

                        if (response.data) {
                            var tr = `
                                <tr>
                                    <td hidden class="caja_id"> ${response.data.id} </td>
                                    <td class="caja_fecha"> ${response.data.inicio_fecha} ${response.data.inicio_hora}</td>
                                    <td class="caja_montoinicio">  ${response.data.monto_inicio}  </td>
                                    <td> ${response.data.monto_estimado} </td>
                                    <td> ${response.data.ingresos} </td>
                                    <td> ${response.data.egresos} </td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#default"> Cerrar</button>
                                    </td>
                                </tr>
                            `;
                            $(".caja-abierta").html(tr);
                            $("#ingreso-caja").modal("hide")
                        }
                        if (response.errors) {
                            response.errors.forEach(element => {
                                console.log(element)
                                Toastify({
                                    text: element,
                                    duration: 3000,
                                    close: true,
                                    //backgroundColor: "#4fbe87"
                                }).showToast();
                            })
                        }
                        if (response.message) {

                            Toastify({
                                text: response.message,
                                duration: 3000,
                                close: true,
                                //backgroundColor: "#4fbe87"
                            }).showToast();

                        }
                    },
                    error: function(response) {
                        console.log(response)
                        Toastify({
                            text: JSON.parse(response.responseText).message,
                            duration: 3000,
                            close: true,
                            //backgroundColor: "#4fbe87"
                        }).showToast();
                    }

                }); //

            }); //



            $(document).on("click", ".registro-egreso-guardar", function() {
                var importe = $(".egreso-importe").val();
                var comentario = $.trim($(".egreso-comentario").val());

                // validaciones
                // end validaciones

                var data = {
                    importe: importe,
                    comentario: comentario
                }
                console.log(data)

                $.ajax({
                    type: "post",
                    url: "cajas/egreso",
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.data) {
                            var tr = `
                                <tr>
                                    <td hidden class="caja_id"> ${response.data.id} </td>
                                    <td class="caja_fecha"> ${response.data.inicio_fecha} ${response.data.inicio_hora}</td>
                                    <td class="caja_montoinicio">  ${response.data.monto_inicio}  </td>
                                    <td> ${response.data.monto_estimado} </td>
                                    <td> ${response.data.ingresos} </td>
                                    <td> ${response.data.egresos} </td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#default"> Cerrar</button>
                                    </td>
                                </tr>
                            `;
                            $(".caja-abierta").html(tr);
                            $("#egreso-caja").modal("hide")
                        }
                        if (response.errors) {
                            response.errors.forEach(element => {
                                console.log(element)
                                Toastify({
                                    text: element,
                                    duration: 3000,
                                    close: true,
                                    //backgroundColor: "#4fbe87"
                                }).showToast();
                            })
                        }
                        if (response.message) {

                            Toastify({
                                text: response.message,
                                duration: 3000,
                                close: true,
                                //backgroundColor: "#4fbe87"
                            }).showToast();

                        }
                    },
                    error: function(response) {
                        console.log(response)
                        Toastify({
                            text: JSON.parse(response.responseText).message,
                            duration: 3000,
                            close: true,
                            //backgroundColor: "#4fbe87"
                        }).showToast();
                    }

                }); //

            }); //







            $(document).on("change", ".filtro", function() {
                getdata();
            });

            // paginacion 
            $(document).on("click", " .pagination a", function(e) {
                e.preventDefault();
                var page = $(this).attr("href").split('page=')[1];
                console.log(page)
                getdata(page);
            });


            function getdata(page = null) {
                var url = window.location.origin + window.location.pathname + "/filtro";
                var desde = $(".filtro-desde").val();
                var hasta = $(".filtro-hasta").val();
                console.log(url)
                var data = {
                    desde: desde,
                    hasta: hasta,
                    page: page
                }

                $.ajax({
                    type: "get",
                    url: url,
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        $("#tabla").html(response);
                    },
                    error: function(response) {
                        Toastify({
                            text: JSON.parse(response.responseText).message,
                            duration: 3000,
                            close: true,
                            //backgroundColor: "#4fbe87"
                        }).showToast();
                    }

                });
            }

        });
    </script>
@endsection
