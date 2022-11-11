@extends('layouts.app')
@section('title')
    Roles editar
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection

@section('content')
    {{-- <div class="page-heading mx-3">
        <a class="btn" href="{{ url('roles') }}"> <i class="bi bi-arrow-left"></i> Volver atras</a>

        <div class=" d-flex justify-content-start ">
            <h3>Editar roles</h3> 
        </div>
    </div> --}}


    <div class="page-heading mx-3 mb-1">
        <div class="mb-3 mt-0">
            @can("ver.roles")
            <a class="btn btn-outline-success mt-1 " href="{{ url('roles') }}"> Listado de Roles</a>
            @endcan
            @can("agregar.roles")
            <a class="btn btn-outline-success mt-1 " href="{{ url('roles/nuevo') }}">Nuevo rol</a>
            @endcan
        </div>

        <div class=" d-flex justify-content-start">
            <h3>Editar rol </h3>
        </div>
    </div>



    <div class="page-content">


        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">


                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Nombre de Rol</label>
                                    <input type="text" class="form-control nombre-rol" value="{{ $role['name'] }}" data-id="{{$role['id']}}">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> Permisos </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                {{-- $permisos_categorias = Permission::select("id","name","description")->where("name","ilike","%.categorias")->get(); --}}
                                @php
                                    // dd($permisos);
                                @endphp
                                @if (isset($permisos) && count($permisos))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Permisos</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Categorias">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Categorias" id="Categorias">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Categorias "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{-- {{ $item['description'] }} --}}
                                                            {{ $item['name'] }}

                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                {{-- $permisos_articulos = Permission::select("id","name","description")->where("name","ilike","%.articulos")->get(); --}}
                                @if (isset($permisos_articulos) && count($permisos_articulos))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Articulos</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Articulos">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Articulos" id="Articulos">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_articulos as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Articulos "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                {{-- $permisos_clientes = Permission::select("id","description")->where("name","ilike","%.clientes")->get(); --}}
                                @if (isset($permisos_clientes) && count($permisos_clientes))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Clientes</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Clientes">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Clientes" id="Clientes">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_clientes as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Clientes "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                {{-- $permisos_proveedores = Permission::select("id","name","description")->where("name","ilike","%.proveedores")->get(); --}}
                                @if (isset($permisos_proveedores) && count($permisos_proveedores))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Proveedores</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Proveedores">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Proveedores" id="Proveedores">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_proveedores as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Proveedores "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif


                                {{-- $permisos_compras = Permission::select("id","name","description")->where("name","ilike","%.compras")->get(); --}}
                                @if (isset($permisos_compras) && count($permisos_compras))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Compras</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Compras">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Compras" id="Compras">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_compras as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check  Compras"
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                {{-- $permisos_ventas = Permission::select("id","name","description")->where("name","ilike","%.ventas")->get(); --}}
                                @if (isset($permisos_ventas) && count($permisos_ventas))
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5>Ventas</h5>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <div class="custom-control custom-checkbox">
                                                <label class="form-check-label" for="Ventas">
                                                    <input type="checkbox"
                                                        class="form-check-input form-check-primary form-check-glow  "
                                                        name="Ventas" id="Ventas">
                                                    Seleccionar todos
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        @foreach ($permisos_ventas as $item)
                                            <div class="form-check me-1">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="{{ $item['name'] }}">
                                                        <input type="checkbox" {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                            class="form-check-input form-check-primary form-check-glow input-check  Ventas"
                                                            name="id_name" data-id="{{ $item['id'] }}"
                                                            id="{{ $item['name'] }}">
                                                        {{ $item['description'] }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                @endif

                                {{-- $permisos_caneros = Permission::select("id","name","description")->where("name","ilike","%.caneros.caneros")->get(); --}}
                                @if (isset($permisos_caneros) && count($permisos_caneros))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Cañeros</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Cañeros">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Cañeros" id="Cañeros">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_caneros as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check  Cañeros "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif




                                {{-- $permisos_items_caneros = Permission::select("id","name","description")->where("name","ilike","%.items.caneros")->get(); --}}
                                @if (isset($permisos_items_caneros) && count($permisos_items_caneros))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Items Cañeros</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Items">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Items" id="Items">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_items_caneros as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check  Items"
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif



                                {{-- $permisos_compra_caneros = Permission::select("id","name","description")->where("name","ilike","%.compra.caneros")->get(); --}}
                                @if (isset($permisos_compra_caneros) && count($permisos_compra_caneros))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Compra Cañeros</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Compra_cañeros">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Compra_cañeros" id="Compra_cañeros">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_compra_caneros as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check  Compra_cañeros"
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif



                                {{-- $permisos_remitos_caneros = Permission::select("id","name","description")->where("name","ilike","%.remitos.caneros")->get(); --}}
                                @if (isset($permisos_remitos_caneros) && count($permisos_remitos_caneros))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Remitos Cañeros</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Remitos_Cañeros">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Remitos_Cañeros" id="Remitos_Cañeros">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_remitos_caneros as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Remitos_Cañeros "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif



                                {{-- $permisos_cheques = Permission::select("id","name","description")->where("name","ilike","%.cheques")->get(); --}}
                                @if (isset($permisos_cheques) && count($permisos_cheques))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Cheques</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Cheques">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Cheques" id="Cheques">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_cheques as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Cheques "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif
 
                                {{-- $permisos_roles = Permission::select("id","name","description")->where("name","ilike","%.roles")->get(); --}}
                                @if (isset($permisos_roles) && count($permisos_roles))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Roles</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Roles">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Roles" id="Roles">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_roles as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check  Roles"
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif



                                {{-- $permisos_usuarios = Permission::select("id","description")->where("name","ilike","%.usuarios")->get(); --}}
                                @if (isset($permisos_usuarios) && count($permisos_usuarios))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Usuarios</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Usuarios">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Usuarios" id="Usuarios">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_usuarios as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check  Usuarios "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif



                                {{-- $permisos_inicio = Permission::select("id","name","description")->where("name","ilike","%.inicio")->get(); --}}
                                @if (isset($permisos_inicio) && count($permisos_inicio))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Panel de Inicio</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Inicio">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Inicio" id="Inicio">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_inicio as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Inicio "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif


                                {{-- $permisos_configuracion = Permission::select("id","name","description")->where("name","ilike","%.configuraciones")->get(); --}}
                                @if (isset($permisos_configuracion) && count($permisos_configuracion))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Configuracion</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Configuracion">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Configuracion" id="Configuracion">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_configuracion as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Configuracion "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                {{-- $permisos_informes = Permission::select("id","name","description")->where("name","ilike","%.informe")->get(); --}}
                                @if (isset($permisos_informes) && count($permisos_informes))
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Informes</h5>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                <div class="custom-control custom-checkbox">
                                                    <label class="form-check-label" for="Informes">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-primary form-check-glow  "
                                                            name="Informes" id="Informes">
                                                        Seleccionar todos
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            @foreach ($permisos_informes as $item)
                                                <div class="form-check me-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <label class="form-check-label" for="{{ $item['name'] }}">
                                                            <input type="checkbox"  {{isset($mis_permisos[$item["id"]]) ? "checked": ''}}
                                                                class="form-check-input form-check-primary form-check-glow input-check Informes "
                                                                name="id_name" data-id="{{ $item['id'] }}"
                                                                id="{{ $item['name'] }}">
                                                            {{ $item['description'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                <div class="col-lg-12">
                                    <button class="btn btn-lg btn-block btn-primary guardar-permisos">Guardar</button>
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
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    <script defer src="{{ asset('js/resources/roles.edit.js') }}"></script>
    {{-- <script defer src="{{ asset('js/roles.edit.min.js') }}"></script> --}}

      
@endsection
