@extends('layouts.app')
@section('title')
    Estadisticas y/o Reportes
@endsection

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}"> --}}
    {{-- <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/table.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection

@section('content')
    <div class="page-heading mx-3 mb-1 ">
        {{-- <div class="mb-3 mt-0">
            <button class="btn btn-outline-success mt-1" data-bs-toggle="modal" data-bs-target="#nuevo-articulo"><strong>+</strong>NUEVO</button>
            <a class="btn btn-outline-success mt-1" href="{{url("categorias")}}" > CATEGORIA DE ARTICULOS</a>
        </div> --}}
        <div class=" d-flex justify-content-start">
            <h3> Estadisticas </h3>
        </div>
    </div>
    <div class="page-content">

        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0" id="table-hover-row">

                @hasanyrole("administrador")
                <div class="row">
                    @include('estadisticas.submenu')
                    <div class="col-lg-10 col-md-10 col-xl-10 ">
                        <div class="row">
                             @include('estadisticas.turno1_2')
                        </div>
                    </div>
                </div>
                @endrole

                @hasanyrole("vendedor")
                <div class="row">
                    @include('estadisticas.turno1_2')
                </div>
                @endrole



            </div>
        </section>







    </div>
@endsection


@section('scripts')
@hasanyrole("administrador")
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/ui-apexchart_.js') }}"></script> --}}
    <script>
        $(document).ready(async function() {
            var bar
            getAjax()

            async function getAjax(url = null) {
                if (url == null) {
                    url = window.location.origin + "/estadisticas"
                }

                console.log(url)
                var data = {}
                await $.ajax({
                    type: "get",
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
                        if (response) {
                            charjss(response)
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


            function charjss(data) {
                var barOptions = {
                    series: [
                        // {
                        //     name: "Pedidos ordenados",
                        //     data: data.ordenado,
                        // },
                        {
                            name: "Pedidos en preparacion",
                            data: data.preparacion,
                        },
                        {
                            name: "Pedidos enviados",
                            data: data.enviado,
                        },
                        {
                            name: "Pedidos cancelados",
                            data: data.cancelado,
                        },
                    ],
                    chart: {
                        type: "bar",
                        height: 400,
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "55%",
                            endingShape: "rounded",
                        },
                    },
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ["transparent"],
                    },
                    xaxis: {
                        // categories: [ "dom 22","lun 23", "mar 24","mier 25", "jue 26", "vier 27","sab 28"],
                        categories: data.categories,
                    },
                    yaxis: {
                        title: {
                            text: "",
                        },
                    },
                    fill: {
                        opacity: 1,
                        colors: ['#f2e82c', '#0bd018', '#ff0000']
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " ";
                            },
                        },
                    },
                };


                bar = new ApexCharts(document.querySelector("#bar"), barOptions);

                bar.render().then(() => bar.ohYeahThisChartHasBeenRendered = true)

            } // end function charjs


            function destroyChart() {
                if (bar.ohYeahThisChartHasBeenRendered) {
                    bar.destroy();
                    bar.ohYeahThisChartHasBeenRendered = false;
                }
            }

            $(document).on("click", ".filtro-dia", function() {
                var url = window.location.origin + "/estadisticas?filtro=dia"
                $("#bar").empty()
                destroyChart()
                getAjax(url)
            })

            $(document).on("click", ".filtro-semana", function() {
                var url = window.location.origin + "/estadisticas?filtro=semana"
                $("#bar").empty()
                destroyChart()
                getAjax(url)
            })

            $(document).on("click", ".filtro-mes", function() {
                var url = window.location.origin + "/estadisticas?filtro=mes"
                $("#bar").empty()
                destroyChart()
                getAjax(url)
            })

            $(document).on("click", ".filtro-anio", function() {
                var url = window.location.origin + "/estadisticas?filtro=anio"
                $("#bar").empty()
                destroyChart()
                getAjax(url)
            })




        });
    </script>
@endrole
@endsection
