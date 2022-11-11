@extends('layouts.app')
@section('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" type="text/css"> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script src="{{asset('js/jquery.3.5.1.min.js')}}"></script>
{{-- <script src="ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
<link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
<script src="{{asset('js/toastr.min.js')}}"></script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Alert!</strong> {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Nuevo Rol </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="role-name">Rol</label>
                        <input class="form-control" name="role-name" id="role-name" type="text" placeholder="role name">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-success btn-sm role-save">
                        Guardar
                    </button>
                </div>
            </div>

            @if (isset($roles) && !empty($roles))
            <div class="card mt-3">
                <div class="card-header">
                    <div class="card-title">Listado de roles</div>
                </div>
                <div class="card-body ">
                    <div class="table table-responsive  table-sm">
                        <table class="table table-light   table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th>Rol</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="container tbody-list">
                                @foreach ($roles as $item)
                                <tr>
                                    <td hidden="hidden">
                                        <input type="text" class="role_id" value="{{$item->id}}">
                                    </td>
                                    <td class="col">
                                        {{$item->name}}
                                    </td>
                                    <td class="d-flex">
                                        <a href="{{route('role.edit',$item->id)}}">
                                            <button class="btn btn-sm btn-outline-info role-edit">Ver</button>
                                        </a>    
                                        <button class="btn mx-1 btn-sm btn-outline-danger role-destroy">Eliminar</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
{{-- <script src="{{asset('resources/js/_roles_i.js')}}"></script> --}}
<script>
    $(document).ready(function () {
        
    });
</script>
@endsection