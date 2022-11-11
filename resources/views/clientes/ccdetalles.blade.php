@extends('layouts.app')
@section('title')
    Clientes cuenta corriente detalle
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection

@section('content')


    <div class="page-heading mx-3">
        <div class=" d-flex justify-content-start mx-3">
            <h3>Cuenta corriente</h3>
            <div>

                <!-- <a class="btn btn-outline-success mx-2" href="_proveedores.nuevo.php">Nuevo pago</a> -->
                <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#ingresar-pago">Nuevo
                    pago</button>
            </div>
        </div>
    </div>


    <div class="page-content">

        <section id="basic-vertical-layouts">

            <div class="row match-height mx-0">

                <div class="col-lg-4">
                    <div class="col ">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Saldo</h6>
                                        <h6 class="font-extrabold mb-0 saldo" data-monto="{{ $info->total }}">
                                            {{ $info->total }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col ">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <h4>Cliente</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="">
                                            <div class="form-group">
                                                <label>Nombre o Razon Social</label>
                                                <input disabled type="text" id="first-name" class="form-control"
                                                    placeholder="nombre" value="{{ $cliente['nombre'] }}">
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="form-group">
                                                <label>Mail</label>
                                                <input disabled type="email" id="first-name" class="form-control"
                                                    placeholder="" value="{{ $cliente['email'] }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="">
                                            <div class="form-group">
                                                <label>Telefono</label>
                                                <input disabled type="text" id="first-name" class="form-control"
                                                    placeholder="" value="{{ $cliente['telefono'] }}">
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="form-group">
                                                <label>Direccion</label>
                                                <input disabled type="text" id="first-name" class="form-control"
                                                    placeholder="" value="{{ $cliente['direccion'] }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="col">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <h4>Historial Pagos</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Importe</th>
                                                    <th>Saldo anterior</th>
                                                </tr>
                                            </thead>
                                            <tbody class="listado-pagos">
                                                @if (isset($pagos) && !empty($pagos))
                                                    @foreach ($pagos as $item)
                                                        <tr>
                                                            <td hidden class="id" data-id="{{ $item['id'] }}">
                                                            </td>
                                                            <td>{{ $item['fecha'] }}</td>
                                                            <td>{{ $item['monto'] }}</td>
                                                            <td>{{ $item['monto_anterior'] }}</td>

                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                        <div class="mt-2">
                                            @if (isset($pagos) && !empty($pagos))
                                                {{ $pagos->render() }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </section>





        <!--Basic Modal  ingresar pago-->
        <div class="modal fade text-left" id="ingresar-pago" data-bsbackdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel11" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel11">Ingresar nuevo pago</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" id="first-name" class="form-control fecha-pago"
                                placeholder="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                        </div>


                        <div class="form-group">
                            <label>Tipo de pago</label>
                            <select class="form-select tipo-pago" name="" id="">
                                @if (isset($tipopagos) && !empty($tipopagos))
                                    @foreach ($tipopagos as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Monto</label>
                            <input type="number" id="first-name" class="form-control monto-pago" placeholder="">
                        </div>

                        {{-- <div class="form-group">
                            <label>Comentario</label>
                            <textarea type="text" id="first-name" class="form-control" 
                                placeholder="Categoria"></textarea>
                        </div> --}}

                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">
                                Salir
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success btn-block guardar-ingresar-pago"  disabled>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>

@endsection




@section('scripts')
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
    <script>
        $(document).ready(function() {
            $(document).on("keyup",".monto-pago",function(){
                $(".guardar-ingresar-pago").removeAttr("disabled");
                $(".guardar-ingresar-pago").removeClass("disabled");
            });


            $(document).on("click", ".guardar-ingresar-pago", function() {
                var url = window.location.origin + window.location.pathname + "/ingresarpago";
                var fecha =  $(".fecha-pago").val();
                var tipopago = $(".tipo-pago").val();
                var monto =  $.trim($(".monto-pago").val());

                var data = {
                    fecha: $(".fecha-pago").val(),
                    monto: $(".monto-pago").val(),
                    tipopago: $(".tipo-pago").val()
                }
                if(monto.length <= 0) return false;

                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.status == "success") {
                            if (response.data.importe) {
                                var saldo = parseFloat($(".saldo").attr("data-monto"));
                                saldo = saldo - response.data.importe;
                                $(".saldo").text(saldo);
                                $(".saldo").attr("data-monto", saldo);
                            }

                            var tr = `
                                <tr>
                                    <td>${response.data.fecha}</td>
                                    <td>${response.data.importe}</td>
                                    <td>${response.data.saldo_anterior} </td>
                                </tr>
                            `;
                            $(".listado-pagos").prepend(tr);
                            $("#ingresar-pago").modal("hide")
                        }
                        if (response.message) {
                            Toastify({
                                text: response.message,
                                duration: 3000,
                                close: true,
                                //backgroundColor: "#4fbe87"
                            }).showToast();

                        }
                    },
                    error: function(response) {
                        Toastify({
                            text: JSON.parse(response.responseText).message,
                            duration: 3000,
                            close: true,
                            //backgroundColor: "#4fbe87"
                        }).showToast();
                    }

                });
            });
        });
    </script>




@endsection
