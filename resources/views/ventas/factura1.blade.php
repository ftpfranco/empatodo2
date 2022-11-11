<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token"  >

    <title> </title>

    {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}

    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"> -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/css2.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}"> --}}


    {{-- <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}"> --}}

</head>

<body>

    <div class="container">

        <div class="row" id="table-hover-row">

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-3">
                                        <img width="100" height="100"
                                            src="https://yt3.ggpht.com/-3BKTe8YFlbA/AAAAAAAAAAI/AAAAAAAAAAA/ad0jqQ4IkGE/s900-c-k-no-mo-rj-c0xffffff/photo.jpg"
                                            alt="">
                                    </div>
    
                                    <div class="col">
    
                                        <strong>EMPRESA</strong>
                                        <div>
                                            <label for="">DIRECCION</label>
    
                                        </div>
                                        <div>
                                            <label for="">+445 454564 34</label>
                                        </div>
                                        <div>
                                            <label for="">{{date("Y-m-d H:m")}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body ">
                                <strong>Cliente</strong>
                                <div>
                                    <label for="">Nombre cliente</label>

                                </div>
                                <div>
                                    <label for="">Direccion</label>
                                </div>
                                <div>
                                    <label for="">Direccion</label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body tabla" id="tabla">
                                <div class="table-responsive mt-4"  >
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Cant</th>
                                                <th>Descripcion</th>
                                                <th>SubTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>23</td>
                                                <td>Lorem ipsum dolor sit amet consectetur adipisicing
                                                    elit. Aperiam, omnis.</td>
                                                <td>213</td>
                                            </tr>

                                            <tr class="table-active">
                                                <td colspan="2"><strong>Descuento %</strong></td>
                                                <td>32 </td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>


</body>
