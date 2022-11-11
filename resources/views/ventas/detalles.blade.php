@extends('layouts.app')
@section('title')
    Ventas detalles
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')


    <div class="page-heading mx-3">
        <div class="d-flex justify-content-start">
            <h3>Ventas</h3>
        </div>
    </div>
    <div class="page-content">

        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="col-12">
                    <div class="card">
                        
                        <div class="card-content">
                            <div class="card-body tabla" id="tabla">
                                @include('ventas.detalles_data')
                            </div>

                        </div>
                    </div>
                </div>



            </div>
        </section>
 
  

    </div>


@endsection

 