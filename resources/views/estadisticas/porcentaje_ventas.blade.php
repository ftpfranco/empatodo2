@extends('layouts.app')
@section('title')
    Porcentaje de Ventas
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

                <div class="row">
                    @include('estadisticas.submenu')

                    <div class="col-lg-10 col-md-10 col-xl-10 ">
                        <div class="card shadow">

                            <div class="card-body ">
                                <div class="card-title my-0 py-0"> Porcentaje de Ventas </div>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="estadisticas" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <div class="col-lg-12 mt-4">
                                            <div class="card">
                                                <div class="d-flex justify-content-end">
                                                    <div class=" btn-group mb-3 btn-group-sm" role="group"
                                                        aria-label="Basic example">
                                                        <button type="button"
                                                            class="btn btn-primary filtro-dia">Dia</button>
                                                        <button type="button"
                                                            class="btn btn-primary filtro-semana">Semana</button>
                                                        <button type="button"
                                                            class="btn btn-primary filtro-mes">Mes</button>
                                                        <button type="button"
                                                            class="btn btn-primary filtro-anio">A&ntilde;o</button>
                                                    </div>
                                                </div>
                                                <div class="card-body px-0">
                                                    <div id="bar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>




            </div>
        </section>







    </div>
@endsection


@section('scripts')
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
                    url = window.location.origin + "/estadisticas/porcentaje_ventas"
                }

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
                        if (response.status == "success") { }
                        if (response) {
                            charjsPer(response)
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
                        Toastify({
                            text: JSON.parse(response.responseText).message,
                            duration: 3000,
                            close: true,
                            //backgroundColor: "#4fbe87"
                        }).showToast();
                    }
                }); // ajax

            }
 


            function charjsPer(data) {
                var options = {
                    series: data.ventas,
                    chart: {
                        width: 500,
                        type: 'pie',
                    },
                    
                    // labels:  ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                    labels:  data.categories,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 250
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                if( document.querySelector("#bar") !== null ){
                    bar = new ApexCharts(document.querySelector("#bar"), options);
                    bar.render().then(() => bar.ohYeahThisChartHasBeenRendered = true)
                }

            } // end function charjs

            function destroyChart() {
                if (bar.ohYeahThisChartHasBeenRendered) {
                    bar.destroy();
                    bar.ohYeahThisChartHasBeenRendered = false;
                }
            }

            $(document).on("click", ".filtro-dia", function() {
                var url = window.location.origin + "/estadisticas/porcentaje_ventas?filtro=dia"
                $("#bar").empty()
                destroyChart()
                getAjax(url)
            })

            $(document).on("click", ".filtro-semana", function() {
                var url = window.location.origin + "/estadisticas/porcentaje_ventas?filtro=semana"
                $("#bar").empty()
                destroyChart()
                getAjax(url)
            })

            $(document).on("click", ".filtro-mes", function() {
                var url = window.location.origin + "/estadisticas/porcentaje_ventas?filtro=mes"
                $("#bar").empty()
                destroyChart()
                getAjax(url)
            })

            $(document).on("click", ".filtro-anio", function() {
                var url = window.location.origin + "/estadisticas/porcentaje_ventas?filtro=anio"
                $("#bar").empty()
                destroyChart()
                getAjax(url)
            })




        });
    </script>
@endsection
