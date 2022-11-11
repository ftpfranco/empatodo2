@extends('layouts.applogin')

@section('content')
  








    <div class="container col-lg-6 col-md-6">
        <div class="pt-4 mt-4 mb-4 pb-4 ">
        </div>
        <div class=" col-12">
            <div id=" ">
                <div class="py-4"></div>

                <div class="auth-logo">
                    <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a>
                </div>
                <h1 class="auth-title">Forgot Password</h1>
                <p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>

                <form action="index.html">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" class="form-control form-control-xl" placeholder="Email">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-block btn-lg shadow-lg mt-5" href="{{ route('verification.resend') }}">Send</a>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'>Remember your account? 
                        <a href="auth-login.html" class="font-bold">Log  in</a>.
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
