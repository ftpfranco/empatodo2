@extends('layouts.app')

@section('content')
    {{-- <div class="page-heading mx-3">
        <h3> Principal </h3>
    </div> --}}

    <div class="page-content">
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0" id="table-hover-row">
                <div class="col-12 ">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldBuy"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold"> Compras </h6>
                                            <h6 class="font-extrabold mb-0"> {{ isset($cant_compras->cantidad)?$cant_compras->cantidad:0 }}</h6>
                                            <h6 class="font-extrabold mb-0">${{ isset( $cant_compras->monto)?$cant_compras->monto:0 }}</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldChart"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold"> Ventas </h6>

                                            <h6 class="font-extrabold mb-0">{{ isset($cant_ventas->cantidad) ?$cant_ventas->cantidad :0}}</h6>
                                            <h6 class="font-extrabold mb-0">${{ isset($cant_ventas->monto)?$cant_ventas->monto:0 }}</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldDownload"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold"> Ingresos</h6>

                                            <h6 class="font-extrabold mb-0">{{ isset( $cant_ingresos->cantidad) ?$cant_ingresos->cantidad:0 }}</h6>
                                            <h6 class="font-extrabold mb-0">${{ isset($cant_ingresos->monto) ? $cant_ingresos->monto :0}}</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="iconly-boldUpload"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold"> Egresos </h6>

                                            <h6 class="font-extrabold mb-0">{{ isset($cant_egresos->cantidad) ?$cant_egresos->cantidad :0}}</h6>
                                            <h6 class="font-extrabold mb-0">${{ isset($cant_egresos->monto) ?$cant_egresos->monto:0 }}</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                 

                <div class="col-lg-12 col-md-6">
                    <div class="card">
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
    <script src="{{ secure_asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    {{-- <script src="{{secure_asset('assets/js/pages/dashboard.js')}}"></script> --}}
    <script src="{{ secure_asset('assets/js/pages/ui-apexchart_.js') }}"></script>
@endsection
