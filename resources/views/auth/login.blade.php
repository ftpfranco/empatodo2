@extends('layouts.applogin')
@section('title')
    Login
@endsection

@section('content')

    <div class="container col-lg-4 col-md-6 ">
        @if (isset($errors) && count($errors)>0)
            <div class="pt-4 mt-4 mb-4 pb-4 ">
                @foreach ($errors->all() as  $item)
                <div class="alert alert-danger alert-dismissible ">
                    {{$item}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endforeach
            </div>
        @endif
        <div class="col-12 ">
            <div class="login">
                <div class="auth-logo text-center ">
                    <a href="{{url('ventas-diarias')}}"><img class="img-fluid" src="{{asset('images/logo.jpg')}}" alt="Logo"></a>
                </div>

                {{-- <h1 class="auth-title">Log in.</h1> --}}
                {{-- <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p> --}}

                <div class="py-4"></div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" name="email"  required class="form-control form-control-xl" placeholder="usuario@email.com">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" required class="form-control form-control-xl" placeholder="contrase&ntilde;a">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    {{-- <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">
                            Keep me logged in
                        </label>
                    </div> --}}
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">INGRESAR</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    {{-- <p class="text-gray-600">Don't have an account? <a href="auth-register.html"
                            class="font-bold">Sign
                            up</a>.</p> --}}
                    <p>
                        {{-- <a class="font-bold" href="auth-forgot-password.html">Forgot password?</a> --}}
                        
                        @if (Route::has('password.request'))
                                        <a class="font-bold" href="{{ route('password.request') }}">
                                            {{ __('Olvidaste la contraseña?') }}
                                        </a>
                                    @endif
                        </p>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div> --}}
    </div>

@endsection
@section('scripts')

<script   src="{{  asset('assets/vendors/jquery/jquery.min.js') }}"></script>
<script  >
    $(document).ready(function () {
        $(document).on("click",".btn-close",function(){
            $(this).parent().remove() 
        })
    });
</script>
@endsection