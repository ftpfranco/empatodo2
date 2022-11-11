@extends('layouts.applogin')

@section('content')


  













<div class="container col-lg-6 col-md-6 ">
    <div class="pt-4 mt-4 mb-4 pb-4 ">
    </div>
    <div class="col-12">
        <div id=" ">
            {{-- <div class="auth-logo text-center mb-3">
                <a href="index.html"><img src="{{asset('assets/images/logo/logo.png')}}" alt="Logo"></a>
            </div> --}}
            <h1 class="auth-title">Olvidaste la contraseña</h1>
            <p class="auth-subtitle mb-5 ">Te enviaremos un mail para restablecer la contraseña.</p>

            <form action="{{url("/")}}">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" class="form-control form-control-xl" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
                <a class="btn btn-primary btn-block btn-lg shadow-lg mt-5" href=" ">Send</a>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'> 
                    <a href="{{url("login")}}" class="font-bold">Log  in</a>.
                </p>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div> --}}
</div>


{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
