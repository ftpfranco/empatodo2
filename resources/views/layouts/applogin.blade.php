<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name')}} - @yield('title','Login')</title>
    <meta name="theme-color" content="#040404" />
    <meta name="google" content="notranslate" />
   
    <link rel="shortcut icon" href="{{asset('images/logo.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css')}}">

    @if (env("APP_ENV") !=="local")
        
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PWLDCDCQ1Y"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-PWLDCDCQ1Y');
    </script>
    @endif


</head>

<body>
    <div id="auth">

        @yield('content')
        
    </div>
    @yield('scripts')
</body>

</html>
