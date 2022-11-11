<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="shortcut icon" href="{{asset('images/logo.ico')}}">




    
<title>{{ config('app.name')}} - @yield('title','Home')</title>
   
<meta name="theme-color" content="#040404" />
{{-- <meta name="description" content="Comparte y Descarga  peliculas series documentos sin acortadores. @yield('descripcion')"> --}}
  {{-- Google / Search Engine Tags   --}}
{{-- <meta itemprop="name" content="The Kraken - @yield('title','Descargar y ver Peliculas Series Documentales - the-kraken.tk ')">
<meta itemprop="description" content="Comparte y Descarga  peliculas series documentos sin acortadores . @yield('descripcion')">
<meta itemprop="image" content=""> --}}

 {{-- Facebook Meta Tags   --}}
{{-- <meta property="og:url" content="http://the-kraken.tk">
<meta property="og:type" content="website">
<meta property="og:title" content="The Kraken - @yield('title','Descargar y ver Peliculas Series Documentales - the-kraken.tk ')">
<meta property="og:description" content="Comparte y Descarga  peliculas series documentos sin acortadores. @yield('descripcion') ">
<meta property="og:image" content=""> --}}

 {{-- Twitter Meta Tags  --}}
{{-- <meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="The Kraken - @yield('title','Descargar y ver Peliculas Series Documentales - the-kraken.tk ')">
<meta name="twitter:description" content="Comparte y Descarga  peliculas series documentos sin acortadores. @yield('descripcion') ">
<meta name="twitter:image" content=""> --}}












{{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}

<!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"> -->
<link rel="stylesheet" href="{{ asset('assets/css/css2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

<link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">

<link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.css') }}">

<link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

<!-- <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon"> -->

<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

</style>
<style>
    .responsive {
      width: 100%;
      max-width: 520px !important;
      /* height: auto !important; */
      height: 5.2rem !important;
    }
  </style>

<link rel="stylesheet" href="{{asset('css/loader.css')}}"> 


@yield('styles')
