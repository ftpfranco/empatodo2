@extends('layouts.app')
@section('title')
    Empresa
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')
    <div class="page-heading mx-3">
        <h3>Configuración</h3>
    </div>
    <div class="page-content">


        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header">
                                <h4 class="card-title">Empresa</h4>
                            </div>
                            <div class="card-body">
                                <form class="form form-horizontal ">
                                    <div class="form-body">
                                        <div class="row">

                                            {{-- <div class="col-12  mt-4 text-center ">
                                                <div class="form-group">
                                                    <img class="img-fluid w-50 rounded"
                                                        src="assets/images/samples/architecture1.jpg" alt="Card image cap">
                                                </div>
                                            </div> --}}


                                            {{-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> Logo </label>
                                                    <input type="file" class="form-control empresa-logo" accept="image/*">
                                                </div>
                                                <div hidden class="progresss progress-success progress-sm  mb-4">
                                                    <div class="progresss-bar" role="progressbar" style="width: 0%"
                                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div> --}}



                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label> Razon social </label>
                                                    <input type="text" class="form-control empresa-nombre" placeholder=""
                                                        value="{{ isset($empresa->nombre) ? $empresa->nombre : '' }}">
                                                </div>
                                            </div>



                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Cuit</label>
                                                    <input type="text" class="form-control empresa-cuit" placeholder=""
                                                        value="{{ isset($empresa->cuit) ? $empresa->cuit : '' }}">
                                                </div>
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Mail</label>
                                                    <input type="text" class="form-control empresa-email" placeholder=""
                                                        value="{{ isset($empresa->email) ? $empresa->email : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Telefono</label>
                                                    <input type="text" class="form-control empresa-telefono" placeholder=""
                                                        value="{{ isset( $empresa->telefono) ? $empresa->telefono : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>WhatSapp</label>
                                                    <input type="text" class="form-control empresa-whatsapp" placeholder=""
                                                        value="{{ isset($empresa->whatsapp) ? $empresa->whatsapp : '' }}">
                                                </div>
                                            </div>



                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="provincia">Provincia</label>
                                                    <select name="" class="form-select" id="provincia">
                                                        <option value="1">San miguel de tucuman</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Direccion</label>
                                                    <input type="text" class="form-control empresa-direccion" placeholder=""
                                                        value="{{ isset($empresa->direccion) ? $empresa->direccion : '' }}">
                                                </div>
                                            </div>



                                            <div class="col-lg-12 mt-4">
                                                <button type="button"
                                                    class="btn btn-primary btn-block me-1 mb-1 empresa-guardar">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>



                            </div>


                        </div>
                    </div>
                </div>






                {{-- ventas --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header">
                                <h4 class="card-title">Ventas</h4>
                            </div>
                            <div class="card-body">
                                <form class="form form-horizontal ">
                                    <div class="form-body">
                                        <div class="row">


                                            <div class="col-12">
                                                <div class="col-lg-6">
                                                    <div class="text-center mb-3">
                                                        <img class="rounded img-logo"
                                                            src="{{ isset($empresa->path_thumbnail) && !empty($empresa->path_thumbnail) ? url($empresa->path_thumbnail) : '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 ">
                                                <form id="imagen" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label> Logo para comprobantes </label>
                                                            <input type="file" class="form-control  ventas-logo" name="logo"
                                                                accept="image/*">

                                                        </div>
                                                        <div hidden class="progress progress-success progress-sm  mb-4">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%"
                                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                             
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>

 

            </div>

        </section>





    </div>
@endsection



@section('scripts')
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}

    <script>
        $(document).ready(function() {


            // nuevo empleado modal
            $(document).on('click', '.empresa-guardar', function() {
                var nombre = $(".empresa-nombre").val();
                var cuit = $(".empresa-cuit").val();
                var email = $(".empresa-email").val();
                var telefono = $(".empresa-telefono").val();
                var whatsapp = $(".empresa-whatsapp").val();
                var direccion = $(".empresa-direccion").val();
                var url = window.location.origin + window.location.pathname;

                var data = {
                    nombre: nombre,
                    cuit: cuit,
                    email: email,
                    telefono: telefono,
                    whatsapp: whatsapp,
                    direccion: direccion,
                }

                $.ajax({
                    type: "put",
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

            }); // on







            // logo ventas
            $(document).on('change', '.ventas-logo', function(e) {
                e.preventDefault();
                var file = this.files[0];
                let url = window.location.origin + window.location.pathname + "/logoventas";
                const tam = (this.files[0].size / 1024 / 1024).toFixed(2);
                console.log(file);
                console.log(tam);

                data = new FormData();
                data.append('logo', file);
                // data = new FormData($("#imagen")[0]);
                // var data = {logo:data}

                if (tam > 1) {
                    Toastify({
                        text: "La imagen no debe superar los 2 Megabytes!",
                        duration: 3000,
                        close: true,
                        //backgroundColor: "#4fbe87"
                    }).showToast();
                } else {
                    $('.progress').removeAttr('hidden');
                    $.ajax({
                        // Your server script to process the upload
                        url: url,
                        type: 'POST',
                        // Form data
                        data: data,
                        // Tell jQuery not to process data or worry about content-type
                        // You *must* include these options!
                        cache: false,
                        contentType: false,
                        // contentType: 'multipart/form-data', 
                        processData: false,
                        // mimeType: 'multipart/form-data',    //Property added in 1.5.1
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        complete: function() {
                            $('.progress').attr('hidden', 'hidden');
                        },
                        success: function(response) {
                            console.log(response)
                            // if (res.data.content.length > 0) {
                            //     $('.img-profile').attr('src', res.data.content);
                            // }

                            if (response.data) {
                                $(".img-logo").attr("src", response.data);
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
                        // Custom XMLHttpRequest
                        xhr: function() {
                            var myXhr = $.ajaxSettings.xhr();
                            if (myXhr.upload) {
                                // For handling the progress of the upload
                                myXhr.upload.addEventListener('progress', function(e) {
                                    if (e.lengthComputable) {
                                        $('.progress-bar').attr({
                                            'aria-valuenow': e.loaded,
                                            max: e.total,
                                        });
                                        $('.progress-bar').css({
                                            width: e.loaded,
                                        });
                                    }
                                }, false);
                            }
                            return myXhr;
                        }
                    }); // ajax
                } // else filesize

            }); // change


            // logo profile
            $(document).on('change', '.empresa-logo', function(e) {
                e.preventDefault();
                var file = this.files[0];
                let url = window.location.origin + window.location.pathname + "/logoprofile";
                const tam = (this.files[0].size / 1024 / 1024).toFixed(2);
                console.log(file);
                console.log(tam);

                data = new FormData();
                data.append('logo', file);
                // data = new FormData($("#imagen")[0]);
                // var data = {logo:data}

                if (tam > 1) {
                    Toastify({
                        text: "La imagen no debe superar los 2 Megabytes!",
                        duration: 3000,
                        close: true,
                        //backgroundColor: "#4fbe87"
                    }).showToast();
                } else {
                    $('.progresss').removeAttr('hidden');
                    $.ajax({
                        // Your server script to process the upload
                        url: url,
                        type: 'POST',
                        // Form data
                        data: data,
                        // Tell jQuery not to process data or worry about content-type
                        // You *must* include these options!
                        cache: false,
                        contentType: false,
                        // contentType: 'multipart/form-data', 
                        processData: false,
                        // mimeType: 'multipart/form-data',    //Property added in 1.5.1
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        complete: function() {
                            $('.progresss').attr('hidden', 'hidden');
                        },
                        success: function(response) {
                            console.log(response)
                            // if (res.data.content.length > 0) {
                            //     $('.img-profile').attr('src', res.data.content);
                            // }

                            if (response.data) {
                                $(".profile-logo").attr("src", response.data);
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
                        // Custom XMLHttpRequest
                        xhr: function() {
                            var myXhr = $.ajaxSettings.xhr();
                            if (myXhr.upload) {
                                // For handling the progress of the upload
                                myXhr.upload.addEventListener('progresss', function(e) {
                                    if (e.lengthComputable) {
                                        $('.progresss-bar').attr({
                                            'aria-valuenow': e.loaded,
                                            max: e.total,
                                        });
                                        $('.progresss-bar').css({
                                            width: e.loaded,
                                        });
                                    }
                                }, false);
                            }
                            return myXhr;
                        }
                    }); // ajax
                } // else filesize

            }); // change





        });
    </script>
@endsection
