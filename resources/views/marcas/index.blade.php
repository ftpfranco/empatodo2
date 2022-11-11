@extends('layouts.app')
@section('title')
    Marcas
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection

@section('content')

    <div class="page-heading mx-3">
        <div class=" d-flex justify-content-start">
            <h3>Marcas</h3>
            <div class="mx-2">
                <button class="btn btn-outline-success  " data-bs-toggle="modal" data-bs-target="#nueva-marca">Nuevo</button>
            </div>
        </div>
    </div>
    <div class="page-content">


        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="col">
                    <div class="card">

                        <div class="card-content">
                            <div class="card-body">

                                <!-- tabla -->
                                <div class="table-responsive">
                                    <table class="table table-hover ">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="marcas-listado">
                                            @if (isset($marcas) && !empty($marcas))
                                                @foreach ($marcas as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control edit-marca"
                                                                data-key="false" data-id="{{ $item['id'] }}"
                                                                value="{{ $item['marca'] }}">
                                                        </td>
                                                        <td>
                                                            <button
                                                                class="btn btn-success btn-sm mt-1 marca-editar mt-1">Guardar</button>
                                                            <button class="btn btn-danger btn-sm mt-1 marca-eliminar mt-1"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Eliminar" data-bs-original-title="Eliminar"> <i
                                                                    class="bi bi-trash"></i> </button>

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



            </div>
        </section>



        <!--Basic Modal  nueva marca-->
        <div class="modal fade text-left" id="nueva-marca" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel11">Nueva marca</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Marca *</label>
                            <input type="text" id="first-name" class="form-control nueva-marca"  placeholder=""
                                value="">
                        </div>

                        <div class="mt-2">
                            <small>(*) estos campos son obligatorios</small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success btn-block marca-guardar ">
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

            // imput keyup
            $(document).on("keyup", '.edit-marca', function() {
                $(this).attr("data-key", true);
            });

            // boton guardar modal
            $(document).on("click", '.marca-editar', function() {
                var marca = $(this).parent().parent().find('.edit-marca').val();
                var id = $(this).parent().parent().find(".edit-marca").attr('data-id');
                var data = {
                    id: id,
                    marca: marca
                }

                if ($(this).parent().parent().find(".edit-marca").attr('data-key') == "false")
                    return false;
                $.ajax({
                    type: "put",
                    url: "marcas",
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.status == "success") {
                            $("#nueva-marca").modal("hide");
                            $(".edit-marca").attr('data-key', false);
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
                }); // ajax
            }); // marca-editar

            $(document).on('click', '.marca-guardar', function() {
                var marca = $(".nueva-marca").val();

                var data = {
                    marca: marca,
                }

                $.ajax({
                    type: "post",
                    url: "marcas",
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.status == "success") {
                            $(".nueva-marca").val('');

                            var tr = `
                                <tr>
                                    <td>
                                        <input type="text" class="form-control edit-marca" data-key="false"  
                                            value="${data.marca}">
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm mt-1 marca-editar">Guardar</button>
                                        <button class="btn btn-danger btn-sm mt-1 marca-eliminar">Eliminar</button>
                                    </td>
                                </tr>
                            `;

                            $(".marcas-listado").append(tr);
                            $("#nueva-marca").modal("hide");


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
                }); // ajax

            }); // guardar 






            // eliminar
            $(document).on("click", ".marca-eliminar", async function() {
                var id = $(this).parent().parent().find(".edit-marca").attr('data-id');
                var url = window.location.origin + window.location.pathname + "/" + id + "/delete"

                var data = {
                    id: id
                }


                var status = await Swal.fire({
                    icon: "question",
                    title: "Desea eliminar?",
                    showCancelButton: true,
                })

                if (status.isConfirmed == true && status.value == true) {
                    $(this).parent().parent().remove();
                    $.ajax({
                        type: "delete",
                        url: url,
                        data: data,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.status == "success") {

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
                    }); // ajax
                }

            }); // elminar


        });
    </script>
@endsection
