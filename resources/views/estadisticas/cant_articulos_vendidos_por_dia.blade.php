@extends('layouts.app')
@section('title')
    Estadisticas y/o Reportes
@endsection

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}"> --}}
    {{-- <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/table.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script> --}}
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
    {{-- <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}

    {{-- <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/ui-apexchart_.js') }}"></script> --}}
    
@endrole
@endsection
