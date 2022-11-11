<!DOCTYPE html>
<html lang="es">

<head>
    
    @section('title')
    Mostrador
    @endsection
    @include('partials.head')
    
    <meta name="google" content="notranslate" />
    @if (env('APP_ENV') !== 'local')
        {{-- <!-- Global site tag (gtag.js) - Google Analytics --> --}}
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PWLDCDCQ1Y"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-PWLDCDCQ1Y');
        </script>
    @endif

</head>

<body>
    <div id="apps">

        <div id="loader">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>

        <div id="mains" class='layout-navbar'>

            @include('partials.header_mostrador')

            <div id="main-content mx-0">
                <div class="page-heading mx-3">
                    <div class=" d-flex justify-content-start">
                        <h3>Listado de pedidos </h3>
                        {{-- <div class="mx-2">
                            <button class="btn btn-outline-success  " data-bs-toggle="modal"
                                data-bs-target="#nueva-marca">Nuevo</button>
                        </div> --}}
                    </div>
                </div>
                <div class="page-content">

                    <section id="basic-vertical-layouts">
                        <div class="row match-height mx-0 pedidos-pendientes">
 
                            @if (isset($ventas) && !empty($ventas))
                                @foreach ($ventas as $item)
                                    <div class="col-lg-3 col-xl-2 pedido-{{$item["venta_id"]}}">
                                        <div class="card shadow" style="background-color:#040404 !important ; font-size: 1.2rem !important;">
                                            <div class="card-content  " >
                                                <div class="card-body  px-0 pb-0"  >
                                                    <div class="px-3">
                                                        <div class="form-group">
                                                            <h1><strong  style="color: white !important"> {{$item["cliente"]}} </strong></h1>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover ">
                                                            <tbody class="pedido-listado" style="color: white !important"> 
                                                                @foreach ($item["articulos"] as $item1)
                                                                <tr> <td> <strong>{{$item1["cantidad"]}}</strong></td>  <td> <strong> {{$item1["articulo"]}} </strong> </td>  </tr> 
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
            
                                                </div>
            
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </section>

                    {{-- <!--Basic Modal  nueva marca--> --}}
                    <div class="modal fade text-left" id="nueva-marca" data-bsbackdrop="static" tabindex="-1"
                        role="dialog" aria-labelledby="myModalLabel11" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel11">Nueva marca</h5>
                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Marca *</label>
                                        <input type="text" id="first-name" class="form-control nueva-marca"
                                            placeholder="" value="">
                                    </div>

                                    <div class="mt-2">
                                        <small>(*) estos campos son obligatorios</small>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="col">
                                        <button type="button" class="btn btn-secondary btn-block"
                                            data-bs-dismiss="modal">
                                            Salir
                                        </button>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-success btn-block marca-guardar ">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>




                {{-- footer --}}
                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start mx-3">
                            <p>{{date('Y')}} &copy; FH</p>
                        </div>

                        {{-- <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a href="http://ahmadsaugi.com">FH</a></p>
                        </div> --}}
                    </div>
                </footer>
            </div>


        </div>
    </div>


    {{-- @include('partials.scripts') --}}

    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script> --}}

    {{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> --}}

    {{-- laravel echo  en app.js --}}
    <script defer src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script defer src="{{ asset('js/app.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}


    <script defer src="{{ asset('js/mostrador.min.js') }}">  </script>
    {{-- <script src="{{ asset('js/resources/mostrador.js') }}">  </script> --}}

   



</body>

 