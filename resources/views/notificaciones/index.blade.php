@extends('layouts.app')
@section('title')
    Notificaciones
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection

@section('content')

    <div class="page-heading mx-3">
        <div class=" d-flex justify-content-start">
            <h3>Notificaciones</h3>
        </div>
    </div>
    <div class="page-content">


        <section id="basic-vertical-layouts">
            <div class="row match-height mx-0">

                <div class="col">
                    <div class="card">

                        <div class="card-content">
                            <div class="card-body">

                                @if (isset($notificaciones) && !empty($notificaciones))
                                    @foreach ($notificaciones as $item)
                                        <div class="alert alert-secondary alert-dismissible show fade">
                                            <div>
                                                <a href="{{ route('articulo.edit', $item->articulo_id) }}"
                                                    class="text-reset text-decoration-none"> {{ $item->descripcion }}  </a>    
                                            </div> 
                                            <small>{{ $item->created_at }}</small>
                                            <button type="button" class="btn-close notificacion-eliminar"
                                                data-id="{{ $item->id }}" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mt-3">
                                @if (isset($notificaciones) && !empty($notificaciones))
                                    {{ $notificaciones->render() }}
                                @endif
                            </div>

                        </div>
                    </div>
                </div>



            </div>
        </section>




    </div>

@endsection

@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    {{-- <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script> --}}
 
@endsection
