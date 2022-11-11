@extends('layouts.app')
@section('title')
    Articulo editar
@endsection
@section('styles')
    <link rel="stylesheet" href="{{  asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{  asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{  asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection

@section('content')

    <div class="page-heading d-flex justify-content-start mx-3">
        <h3>Editar articulo</h3>
        <div class="mx-1">
            {{-- <a class="btn btn-outline-success" href=" " >Nuevo</a> --}}
        </div>
    </div>
    <div class="page-content">

        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0" id="table-hover-row">

                <div class=" col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body" id="tabla">


                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" class="form-control editar-articulo" placeholder="" value="{{$articulo->articulo}}">
                                    </div>
        
                                    <input class="editar-id" hidden type="text">
        
        
                                    @if (isset($categorias) && count($categorias)>0)
                                        <div class="form-group">
                                            <label for="">Categoria</label>
                                            <select class=" choices editar-categoria"
                                                data-type="select-one" tabindex="0" role="combobox"
                                                aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                                <option value="0">Seleccione una opcion</option>
                                                @foreach ($categorias as $key => $item)
                                                    @if ($articulo->categoria_id == $key)
                                                    <option value="{{ $key }}" selected>
                                                        {{ $item }} </option>
                                                    @endif
                                                    <option value="{{ $key }}">
                                                        {{ $item }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
        
        
                                    {{-- @if (isset($marcas) && count($marcas)>0)
                                        <div class="form-group">
                                            <label for="">Marca</label>
                                            <select class=" choices editar-marca" data-type="select-one"
                                            tabindex="0" role="combobox" aria-autocomplete="list"
                                            aria-haspopup="true" aria-expanded="false">
                                                <option value="0">Seleccione una opcion</option>
                                                @foreach ($marcas as $key => $item)
                                                @if ($articulo->marca_id == $key)
                                                    <option value="{{ $key }}" selected>
                                                        {{ $item }} </option>
                                                    @endif
                                                    <option value="{{ $key }}">{{ $item }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif --}}
        
        
        
        
                                    <div class="form-group">
                                        <label>Codigo</label>
                                        <input type="text" class="form-control editar-codigo" placeholder="" value="{{$articulo->codigo}}">
                                    </div>
        
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Precio costo</label>
                                                <input type="number" class="form-control editar-preciocompra" placeholder="" value="{{$articulo->precio_compra}}">
                                            </div>
        
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Precio venta</label>
                                                <input type="number" class="form-control editar-precioventa" placeholder="" value="{{$articulo->precio_venta}}">
                                            </div>
                                        </div>
                                    </div>
        
        
        
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Stock</label>
                                                <input type="number" class="form-control editar-stock" placeholder="" value="{{$articulo->stock}}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Stock minimo</label>
                                                <input type="number" class="form-control editar-stockminimo" placeholder="" value="{{$articulo->stock_minimo}}">
                                            </div>
                                        </div>
                                    </div>
        
                                    {{-- <div class="col-12 mt-1 ">
                                        <div class="form-check">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                    class="form-check-input form-check-primary form-check-glow editar-habilitado " {{$articulo->habilitado?"checked":''}}
                                                    name="customCheckw" id="customColorCheck4">
                                                <label class="form-check-label" for="customColorCheck4">Habilitar articulo</label>
                                            </div>
                                        </div>
                                    </div> --}}
                                 

                                   
                                    <div class="mt-3">
                                        <button class="btn btn-success btn-block producto-guardar"> Guardar</button>
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
    <script src="{{  asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/jquery/jquery.min.js')}}"></script>
    
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    
    {{-- <script src="{{ asset('js/resources/articulos.edit.js')}}"></script> --}}
    <script src="{{ asset('js/articulos.edit.min.js')}}"></script>

 
@endsection
