@extends('layouts.app')
@section('title')
    Reportes Ventas
@endsection
@section('content')
    {{-- <div class="page-heading mx-3">
        <h3> Principal </h3>
    </div> --}}

    <div class="page-content">
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0" id="table-hover-row">


                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ventas</h4>
                            </div>
                            <div class="card-body">
                                <div id="area"></div>
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
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js')}}"></script>

    <script>
        var areaVentas = {
            series: [{
                name: "Ventas",
                data: [20, 11, 32, 45, 32, 34, 52, 41,20,25,30,18],
            }, ],
            chart: {
                height: 350,
                type: "area",
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                type: "datetime",
                categories: [
                    "2018-08-17",
                    "2018-09-18",
                    "2018-09-19T01:30:00.000Z",
                    "2018-09-19T02:30:00.000Z",
                    "2018-09-19T03:30:00.000Z",
                    "2018-09-19T04:30:00.000Z",
                    "2018-09-19T05:30:00.000Z",
                    "2018-10-22",
                    "2018-10-24",
                    "2018-12-25",
                    "2018-12-28",
                    "2018-12-29",
                ],
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy HH:mm",
                },
            },
        };

        var area = new ApexCharts(document.querySelector("#area"), areaVentas);

        area.render();
    </script>
@endsection
