@extends('layouts.app')
@section('title')
    Home
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')

    <div class="page-content">
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0" id="table-hover-row">
                <div class="  ">
                    <div class="row">
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="card mb-1 shadow">
                                <div class="card-body px-3 py-4-5">

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldBuy"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="text-muted font-semibold"> Compras </h6>
                                            <h6 class="font-extrabold mb-0"> {{ isset($cant_compras["cantidad"])?$cant_compras["cantidad"]:0 }}</h6>
                                            <h6 class="font-extrabold mb-0">${{ isset( $cant_compras["monto"])?$cant_compras["monto"]:0 }}</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="card mb-1 shadow">
                                <div class="card-body px-3 py-4-5">

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldChart"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="text-muted font-semibold"> Ventas </h6>

                                            <h6 class="font-extrabold mb-0">{{ isset($cant_ventas["cantidad"]) ?$cant_ventas["cantidad"] :0}}</h6>
                                            <h6 class="font-extrabold mb-0">${{ isset($cant_ventas["monto"])?$cant_ventas["monto"]:0 }}</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="card mb-1 shadow">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">

                                        <div class="col-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldDownload"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="text-muted font-semibold"> Ingresos</h6>

                                            <h6 class="font-extrabold mb-0">{{ isset( $cant_ingresos["cantidad"]) ?$cant_ingresos["cantidad"]:0 }}</h6>
                                            <h6 class="font-extrabold mb-0">${{ isset($cant_ingresos["monto"]) ? $cant_ingresos["monto"] :0}}</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="card mb-1 shadow">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">

                                        <div class="col-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldUpload"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="text-muted font-semibold"> Egresos </h6>

                                            <h6 class="font-extrabold mb-0">{{ isset($cant_egresos["cantidad"]) ?$cant_egresos["cantidad"] :0}}</h6>
                                            <h6 class="font-extrabold mb-0">${{ isset($cant_egresos["monto"]) ?$cant_egresos["monto"]:0 }}</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                 

                <div class="col-lg-12 ">
                    <div class="card shadow">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div id="bar"></div>
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
        $(document).ready( async function() {
            var url = window.location.origin + window.location.pathname ;
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
                    if (response.data) {
                        charjss(response.data)
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




            function charjss(data) {
                var barOptions = {
                    series: [{
                            name: "Compras",
                            data: data.compras,
                        },
                        {
                            name: "Ventas",
                            data:  data.ventas,
                        },
                        {
                            name: "Ingresos",
                            data:  data.ingresos,
                        },
                        {
                            name: "Egresos",
                            data:  data.egresos,
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
                        enabled: false,
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ["transparent"],
                    },
                    xaxis: {
                        categories: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct",
                            "Nov", "Dic"
                        ],
                    },
                    yaxis: {
                        title: {
                            text: "$ ",
                        },
                    },
                    fill: {
                        opacity: 1,
                        colors: ['#ff0000', '#0bd018', '#21ede6','#f2e82c']
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "$ " + val + " ";
                            },
                        },
                    },
                };


                var bar = new ApexCharts(document.querySelector("#bar"), barOptions);

                bar.render();

            } // end function charjs
        });
    </script>
@endsection
