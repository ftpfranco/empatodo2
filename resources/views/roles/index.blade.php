@extends('layouts.app')
@section('title')
    Roles
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection

@section('content')
    {{-- <div class="page-heading mx-3">
        <div class=" d-flex justify-content-start ">
            <h3>Roles</h3>
            <div class="mx-1">
                <a href="{{url("roles/nuevo")}}" class="btn btn-outline-success "  >Nuevo</a>
            </div>
        </div>
    </div> --}}

    <div class="page-heading mx-3 mb-1">
        <div class="mb-3 mt-0">
            @can("ver.roles")
            <a class="btn btn-success  mt-1" href="{{ url('roles') }}"> Listado de Roles</a>
            @endcan
            @can("agregar.roles")
            <a class="btn btn-outline-success  mt-1" href="{{ url('roles/nuevo') }}">Nuevo rol</a>
            @endcan
        </div>

        <div class=" d-flex justify-content-start">
            <h3>Listado de roles </h3>
        </div>
    </div>



    <div class="page-content">
 
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">
 
                <div class="col-12">
                    <div class="card">

                        <div class="card-content">
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Rol</th>
                                                <th class="text-end">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="roles-listado">
                                            @if (isset($roles) && !empty($roles))
                                                @foreach ($roles as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="text"  class="hidden  categoria"   data-id="{{ $item['id'] }}"   hidden>
                                                            {{ ucfirst($item['name']) }}
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="{{route("role.edit", $item['id'] ) }}" class="btn btn-success btn-sm mt-1 categoria-editar"  data-bs-toggle="tooltip" data-bs-placement="top"   title="Guardar" data-bs-original-title="Guardar"> <i  class="bi bi-pencil"></i> </a>
                                                            <button   class="btn btn-danger btn-sm mt-1 categoria-eliminar"  data-bs-toggle="tooltip" data-bs-placement="top"  title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i> </button>

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



        {{-- <!--Basic Modal  nueva rol--> --}}
        <div class="modal fade text-left" id="nuevo-rol" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-md " role="document">
                <div class="modal-content ">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="myModalLabel11">Nuevo Rol</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre de Rol *</label>
                            <input type="text" id="first-name" class="form-control categoria" placeholder="">
                        </div>

                        <div>
                            <small>(*) estos campos son obligatorios</small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-light-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block categoria-guardar" disabled>
                                Guardar
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
    <script defer src="{{ asset('js/resources/roles.index.js') }}"></script>
    {{-- <script defer src="{{ asset('js/roles.index.min.js') }}"></script> --}}
 
@endsection
