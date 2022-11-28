@extends('layouts.app')
@section('title')
    Categoria de ingresos
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    
@endsection
@section('content')


<a class="btn" href="{{url('ingresos')}}">  <i class="bi bi-arrow-left"></i> Volver atras</a>
    <div class="page-heading mx-3 mb-1">

        <div class="mb-3 mt-0">
            <button class="btn btn-sm  btn-outline-success mx-2 " data-bs-toggle="modal"
                data-bs-target="#tipo-nuevo"><strong>+</strong>NUEVO</button>
        </div>
        <div class="d-flex justify-content-start">
            <h3> Categorias de ingresos</h3>
        </div>
    </div>
    <div class="page-content">

        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="row">
                    <div class="col">
                        <div class="card shadow">

                            <div class="card-content">
                                <div class="card-body">

                                    {{-- <!-- tabla --> --}}
                                    <div class="table-responsive mt-4">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Categoria </th>
                                                    <th class="text-end">Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody class="listado">
                                                @if (isset($ingresostipos) && !empty($ingresostipos))

                                                    @foreach ($ingresostipos as $item)
                                                        <tr>
                                                            <td hidden class="id" data-id="{{ $item['id'] }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control ingresotipo-list" type="text"
                                                                    data-status="off" value="{{ $item['ingresotipo'] }}">
                                                            </td>
                                                            <td class="text-end">
                                                                <button class="btn btn-success btn-sm ingresotipo-editar mt-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Guardar"
                                                                    data-bs-original-title="Guardar"> <i class="bi bi-archive"></i> </button>
                                                                <button
                                                                    class="btn btn-danger btn-sm ingresotipo-eliminar mt-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Eliminar" data-bs-original-title="Eliminar"> <i
                                                                        class="bi bi-trash"></i> </button>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                        <div class="mt-2">
                                            @if (isset($ingresostipos) && !empty($ingresostipos))
                                                {{ $ingresostipos->render() }}
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>






        {{-- <!--Basic Modal  tipo nuevo--> --}}
        <div class="modal fade text-left" id="tipo-nuevo" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">NUEVA CATEGORIA DE INGRESO</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col ">
                            <div class="form-group">
                                <label for="">Nombre de la categoria</label>
                                <input type="text" class="form-control ingresotipo">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block " data-bs-dismiss="modal">
                                SALIR
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block ingresotipo-nuevo" >
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
   
    {{-- <script defer src="{{ asset('js/resources/ingresostipos.js')}}"></script> --}}
    <script defer src="{{ asset('js/ingresostipos.min.js')}}"></script>
  
@endsection
