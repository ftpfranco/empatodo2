@extends('layouts.app')
@section('title')
    Categorias
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

@endsection

@section('content')
<a class="btn" href="{{url('articulos')}}">  <i class="bi bi-arrow-left"></i> Volver atras</a>
<div class="page-heading mx-3 mb-1">
        <div class="mb-3 mt-0">
            <button class="btn btn-sm  btn-outline-success mx-2 " data-bs-toggle="modal"
                data-bs-target="#nueva-categoria"> <strong>+</strong>NUEVO</button>
        </div>
        <div class=" d-flex justify-content-start ">
            <h3>Categorias de articulos</h3>
        </div>
    </div>
    <div class="page-content">


        {{-- <!-- Basic Vertical form layout section start --> --}}
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">



                <div class="col-12">
                    <div class="card shadow">

                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th class="text-end">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="categorias-listado">
                                            @if (isset($categorias) && !empty($categorias))
                                                @foreach ($categorias as $item)
                                                    <tr>
                                                        <td hidden></td>
                                                        <td>
                                                            <input type="text" class="form-control edit-categoria"
                                                                data-key="false" data-id="{{ $item['id'] }}"
                                                                value="{{ $item['categoria'] }}">
                                                        </td>
                                                        <td class="text-end">
                                                            <button class="btn btn-success btn-sm mt-1 categoria-editar" data-bs-toggle="tooltip" data-bs-placement="top" title="Guardar" data-bs-original-title="Guardar"> <i  class="bi bi-archive"></i>  </button>
                                                            <button class="btn btn-danger btn-sm mt-1 categoria-eliminar"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i  class="bi bi-trash"></i> </button>

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



        <div class="modal fade text-left" id="nueva-categoria" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">NUEVA CATEGORIA</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Categoria *</label>
                            <input type="text"  class="form-control categoria" placeholder="">
                        </div>

                        <div>
                            <small>(*) estos campos son obligatorios</small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                SALIR   
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block categoria-guardar" disabled>
                                GUARDAR
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

    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}


    {{-- <script defer src="{{ asset('js/resources/categorias.js')}}"></script> --}}
    <script defer src="{{ asset('js/categorias.min.js')}}"></script>

    
@endsection
