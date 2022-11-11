@extends('layouts.app')
@section('title')
    Compras editar
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
    <script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
@endsection
@section('content')

    <div class="page-heading mx-3">
        <h3>Editar compra</h3>
    </div>
    <div class="page-content">

        <section id="basic-vertical-layouts">


            <!-- caja cliente articulos  -->
            <div class="row match-height mx-0">
                <div class="col">
                    <div class="card">
                        <div class="card-content">

                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="form-body">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="first-name-vertical">Proveedor</label>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <select class=" choices proveedor" data-type="select-one"
                                                            tabindex="0" role="combobox" aria-autocomplete="list"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <option value="1" selected>Selecciona una opcion</option>
                                                            @if (isset($proveedores) && !empty($proveedores))
                                                                @foreach ($proveedores as $key => $item)
                                                                    @if ($compra->proveedor_id)
                                                                        <option value="{{ $key }}" selected>
                                                                            {{ $item }} </option>
                                                                    @endif
                                                                    <option value="{{ $key }}">{{ $item }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Fecha</label>
                                                    <input type="date" class="form-control fecha" name="fname"
                                                        placeholder="" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>






                                        <div class="row ">
                                            <label for="first-name-vertical">Articulos</label>
                                            <div class="col ">
                                                <div class="form-group">
                                                    <select class=" choices select-articulo" data-type="select-one"
                                                        tabindex="0" role="combobox" aria-autocomplete="list"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        @if (isset($articulos) && !empty($articulos))
                                                            @foreach ($articulos as $item)
                                                                <option
                                                                    value="{{ $item['id'] }}_{{ $item['stock'] }}_{{ $item['precio_venta'] }}_{{ $item['precio_compra'] }}">{{ $item['articulo'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="table">
                                            <!-- Table with outer spacing -->
                                            <div class="table-responsive mt-2">
                                                <table class="table table-hover mb-5">
                                                    <thead>
                                                        <tr>
                                                            <th>Articulo</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio compra</th>
                                                            <th>Precio venta</th>
                                                            <th>Subtotal</th>
                                                            <th>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="articulos-listado">

                                                        @if (isset($detalles) && !empty($detalles))
                                                            @foreach ($detalles as $item)
                                                                <tr>
                                                                    <td class="text-bold-500 articulo-id"
                                                                        data-id="{{ $item['id'] }}"
                                                                        data-articuloid="{{ $item['articulo_id'] }}"
                                                                        hidden> {{ $item['articulo_id'] }} </td>
                                                                    <td class="text-bold-500"> {{ $item['articulo'] }}
                                                                    </td>
                                                                    <td> {{ $item['cantidad'] }} </td>
                                                                    <td> {{ $item['precio_compra'] }} </td>
                                                                    <td> {{ $item['precio_venta'] }} </td>
                                                                    <td class="subtotal"
                                                                        data-monto="{{ $item['subtotal'] }}">
                                                                        {{ $item['subtotal'] }} </td>
                                                                    <td>
                                                                        <label class="btn btn-danger btn-sm articulo-eliminar mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >  <i class="bi bi-trash"></i>  </label>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tbody class="totales">
                                                        {{-- <tr class="table-active">
                                                            <td colspan="2"><strong>Descuento %</strong></td>
                                                            <td colspan="2">
                                                                <input type="text"
                                                                    class="form-control total-descuento-porcentaje"
                                                                    value="{{ isset($compra->descuento_porcentaje) ? $compra->descuento_porcentaje : '' }}">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr> --}}

                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Descuento $ </strong></td>
                                                            <td colspan="2">
                                                                <input type="text"
                                                                    class="form-control total-descuento-monto"
                                                                    value="{{ isset($compra->descuento_importe) ? $compra->descuento_importe : '' }}">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>

                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Subtotal general</strong></td>
                                                            <td colspan="2">
                                                                <input type="text" class="form-control total-subtotal"
                                                                    value="{{ isset($compra->subtotal) ? $compra->subtotal : '' }}">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>

                                                        <tr class="table-active">
                                                            <td colspan="2"><strong>Total </strong></td>
                                                            <td colspan="2">
                                                                <input type="text" class="form-control total-total"
                                                                    value="{{ isset($compra->monto) ? $compra->monto : '' }}">
                                                            </td>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>





                <div class="col-lg-3">
                    {{-- formas de pago --}}
                    <div class="col">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <h4>Agregar pago</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-body">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Tipo de pago</label>
                                                    <select class=" choices tipopago" data-type="select-one" tabindex="0"
                                                        role="combobox" aria-autocomplete="list" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <option value="-1">Seleccione una opcion</option>
                                                        @if (isset($tipo_pagos) && count($tipo_pagos) > 0)
                                                            @if (isset($tipo_pagos) && !empty($tipo_pagos))
                                                                @foreach ($tipo_pagos as $key => $item)
                                                                    <option value="{{ $key }}">
                                                                        {{ $item }}</option>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="monto">Monto</label>
                                                    <input type="number" id="monto" class="form-control  monto" name="monto"
                                                        placeholder="">
                                                </div>
                                            </div>



                                        </div>


                                        <div class="form-group">
                                            <label for="email-id-vertical">Comentario adicional</label>
                                            <textarea type="textarea" id="email-id-vertical"
                                                class="form-control pago-comentario" name="pago-comentario"
                                                placeholder="..."></textarea>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- pagos anteriores --}}
                    <div class="col">

                        @if (isset($pagos) && count($pagos) > 0)
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-header">
                                        <h4>Pagos anteriores</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-body">
                                            @foreach ($pagos as $item)
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>{{ $item['tipo_pago'] }}: <strong>
                                                                {{ $item['monto'] }}</strong> </label>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>











                <div class="row mb-3">
                    <div class="col">
                        <button type="button"
                            class="btn btn-lg btn-block btn-success me-1 mb-1 compra-guardar disabled">Guardar</button>
                    </div>

                    {{-- <div class="col">
                        <button type="button" class="btn btn-lg btn-block btn-secondary me-1 mb-1 compra-factura"
                            disabled>Factura</button>
                    </div> --}}

                    {{-- <div class="col">
                        <!-- crear una factura electronia -->
                        <!-- <button type="button" class="btn btn-lg btn-secondary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#factura-electronica">Factura Electronica</button> -->
                        <!-- <button type="button" class="btn btn-lg btn-secondary me-1 mb-1">Factura Electronica</button> -->
                        <button type="button" class="btn btn-lg btn-block btn-secondary me-1 mb-1 compra-ticket"
                            disabled>Ticket</button>
                        <!-- registra la venta y emite comprobante  -->
                        <!-- <button type="button" class="btn btn-lg btn-secondary me-1 mb-1">Cobrar en caja</button> -->
                    </div> --}}

                </div>

            </div>


        </section>
    </div>




@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}


    <script>
        $(document).ready(function() {

            $(document).on("change", ".tipopago", function() {
                botones_habilitar();

            });

            $(document).on("click", ".monto", function() {
                var total = $(".total-total").val();
                $(".monto").val(total)
            });
            $(document).on("change", ".select-articulo", function() {

                botones_habilitar();

                var articulo_id = $.trim($(this).val());
                var articulo = $.trim($(this).text());
                var value = $.trim($(this).val());
                var arr = value.split("_");
                var id = arr[0];
                var stock = Number(arr[1]);
                var precio_venta = Number(arr[2]);
                var precio_compra = Number(arr[3]);


                var tr = `
                    <tr>
                        <td class="text-bold-500 articulo-id"  data-id="${id}"  data-articuloid="${articulo_id}" data-nuevo="true" hidden> ${articulo_id} </td>
                        <td class="text-bold-500"> ${articulo} </td>
                        <td>
                            <input type="number" class="form-control articulo-cantidad" value="1">
                        </td>
                        <td>
                            <input type="number" class="form-control precio-compra" value="${precio_compra}">
                        </td>
                        <td>
                            <input type="number" class="form-control precio-venta" value="${ precio_venta }">
                        </td>
                        <td class="subtotal" data-monto="${precio_compra}"> ${precio_compra}</td>
                        <td>
                            <label class="btn btn-danger btn-sm articulo-eliminar mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >  <i class="bi bi-trash"></i>  </label>

                        </td>
                    </tr>
                `;
                $(".articulos-listado").append(tr);
                suma_subtotales();
            });

            // tipeo en cantidad articulo
            $(document).on("keyup", ".articulo-cantidad", function() {
                botones_habilitar()
                var cant = $(this).val();
                var precio_compra = $(this).parent().parent().find(".precio-compra").val();
                var sub = cant * precio_compra
                var sub = parseFloat(sub).toFixed(2);
                $(this).parent().parent().find(".subtotal").text(sub);
                $(this).parent().parent().find(".subtotal").attr("data-monto", sub);
                suma_subtotales();
                $(".total-descuento-porcentaje").val('')
                $(".total-descuento-monto").val('')

            });


            $(document).on("keyup", ".precio-compra", function() {
                botones_habilitar()
                var cant = $(this).parent().parent().find(".articulo-cantidad").val();
                var precio_compra = $(this).val();
                var sub = cant * precio_compra
                var sub = parseFloat(sub).toFixed(2);
                $(this).parent().parent().find(".subtotal").text(sub);
                $(this).parent().parent().find(".subtotal").attr("data-monto", sub);
                suma_subtotales();
                $(".total-descuento-porcentaje").val('')
                $(".total-descuento-monto").val('')

            });


            $(document).on("keyup", '.montos', function() {
                botones_habilitar()
                suma_pagos()
            });

            // function myFunction() {
            //     var str = 12.234556;
            //     str = str.toString().split('.');
            //     var res = str[1].slice(0, 2);
            //     document.getElementById("demo").innerHTML = str[0] + '.' + res;
            // }

            $(document).on("keyup", ".total-descuento-porcentaje", function() {
                botones_habilitar()
                var descuento = $(this).val() == undefined ? 0 : $(this).val();
                var total = suma_subtotales();
                var cant_d = (total * (descuento / 100));
                var subt = total - cant_d;
                // subt = subt.toString().split(".");
                // console.log(subt)
                // var res = 0;
                // if (subt[1] != undefined) {
                //     res = subt[1].slice(0, 2)
                // }
                // subt = subt[0] + "." + res;
                cant_d = parseFloat(cant_d).toFixed(2);
                subt = parseFloat(subt).toFixed(2);
                $(".total-descuento-monto").val(cant_d);
                $(".total-total").val(subt);
            });

            $(document).on("keyup", ".total-descuento-monto", function() {
                botones_habilitar()
                // $(".total-descuento-porcentaje").val(0);
                var descuento = ($(this).val() == undefined || $(this).val() == '') ? 0 : $(this).val();
                var total = suma_subtotales();
                var subt = total - descuento;
                if (descuento > 0) {
                    var porcentaje = descuento * (100 / total);
                    $(".total-descuento-porcentaje").val(porcentaje);
                } else {
                    $(".total-descuento-porcentaje").val('');
                }

                subt = parseFloat(subt).toFixed(2);
                $(".total-total").val(subt);
            });


            $(document).on("click", ".articulo-eliminar", function() {
                if ($(this).find('.articulo-id').attr("data-nuevo") == "true") {
                    $(this).parent().parent().remove();
                }
                else{
                    $(this).parent().parent().find(".articulo-id").attr("data-eliminar", "true");
                    $(this).parent().parent().find(".subtotal").removeClass("subtotal");
                    $(this).parent().parent().attr("hidden", "hidden");
                }
              

                botones_habilitar()
                suma_subtotales();
                // $(".total-descuento-porcentaje").val('')
                // $(".total-descuento-monto").val('')
            });

            $(document).on('click', '.compra-guardar', function() {
                send();
            }); // click guardar venta


            function send() {
                var url = window.location.origin + window.location.pathname + "/update";
                console.log(url)
                var data = {
                    "proveedor": $(".proveedor").val(),
                    "fecha": $(".fecha").val(),
                    "pagos_id": $(".tipopago").val(),
                    "pagos_monto": $(".monto").val(),
                    "articulos": {},
                    "eliminados": {},
                    "descuentos": {},
                    // "pagos": {},
                    "comentario": $(".pago-comentario").val(),
                };

                $(".articulos-listado>tr").each(function(i, j) {
                    console.log(i)
                    console.log($(this).val())

                    if ($(this).find('.articulo-id').attr("data-eliminar") == "true") {
                        var id = $(this).find(".articulo-id").attr("data-id")
                        var articulo_id = $(this).find(".articulo-id").attr("data-articuloid")
                        var articulo = {
                            id: id,
                            articulo_id: articulo_id,
                        }
                        data.eliminados[i] = articulo
                    } else {
                        var articulo_id = $(this).find('.articulo-id').attr("data-id");
                        if (articulo_id !== undefined) articulo_id = articulo_id.split("_")[0];
                        var articulo_cantidad = $(this).find(".articulo-cantidad").val();
                        var precio_compra = $(this).find(".precio-compra").val();
                        var precio_venta = $(this).find(".precio-venta").val();

                        var articulo = {
                            articulo_id: articulo_id,
                            articulo_cantidad: articulo_cantidad,
                            precio_compra: precio_compra,
                            precio_venta: precio_venta,
                        };
                        data.articulos[i] = articulo;
                    }

                });
                data.descuentos[0] = {
                    "porcentaje": $.trim($(".total-descuento-porcentaje").val()),
                    "monto": $.trim($(".total-descuento-monto").val())
                }
                // data.pagos[0] = {
                //     "efectivo": $.trim($(".pago-efectivo").val()),
                //     "debito": $.trim($(".pago-debito").val()),
                //     "credito": $.trim($(".pago-credito").val()),
                //     "cc": $.trim($(".pago-cc").val()),
                //     "otro": $.trim($(".pago-otro").val()),
                // }

                console.log(data)
                if (data.articulos == undefined) {
                    Toastify({
                        text: "Agregue articulos para completar la compra!",
                        duration: 3000,
                        close: true,
                        //backgroundColor: "#4fbe87"
                    }).showToast();
                }
                if (data.articulos !== undefined) {
                    $.ajax({
                        type: "put",
                        url: url,
                        data: data,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.status == "success") {
                                // Swal.fire({
                                //     icon: "success",
                                //     title: "Success"
                                // })
                            }
                            if (response.errors) {
                                response.errors.forEach(element => {
                                    console.log(element)
                                    Toastify({
                                        text: element,
                                        duration: 3000,
                                        close: true,
                                        //backgroundColor: "#4fbe87"
                                    }).showToast();
                                })
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
                            console.log(response)
                            Toastify({
                                text: JSON.parse(response.responseText).message,
                                duration: 3000,
                                close: true,
                                //backgroundColor: "#4fbe87"
                            }).showToast();
                        }
                    }); // ajax
                }
            } // end send



            // calcular suma total 
            function suma_subtotales() {
                var sum = 0;
                var descuento = $.trim($(".total-descuento-monto").val());
                // $(".subtotal").each(function() {
                //     sum += parseFloat($(this).attr("data-monto"));
                // });
                $(".articulos-listado>tr").each(function() {
                    if ($(this).find('.articulo-id').attr("data-nuevo") == "true") {
                        sum += parseFloat($(this).find(".subtotal").attr("data-monto"));
                    }
                });

                sum = sum.toFixed(2);
                if (descuento > 0) {
                    sum = sum - descuento;
                }
                sum = isNaN(sum)?0:sum;
                $(".total-subtotal").val(sum);
                $(".total-total").val(sum);
                console.log(sum)
                if (sum < 0) {
                    $(".total-descuento-porcentaje").val('')
                    $(".total-descuento-monto").val('')
                    $(".total-subtotal").val('');
                    $(".total-total").val('');
                }
                return sum;
            }



            function botones_habilitar() {
                // desbloquear boton guardar
                $(".compra-guardar").removeAttr("disabled");
                $(".compra-guardar").removeClass("disabled");
            }


            function botones_bloquear() {
                $(".compra-guardar").Attr("disabled");
            }

            function suma_pagos() {
                var total = $(".total-total").val();
                var vuelto = 0;
                var monto = 0;
                $(".montos").each(function() {
                    var d = ($(this).val() == '' || $(this).val() == null || $(this).val() == undefined) ?
                        0 : parseFloat($(this).val());
                    monto += d;
                });
                if (total == '' || total == null || total == undefined) {
                    $(".pago-vuelto").val(0);
                } else {
                    vuelto = monto - parseFloat(total);
                    $(".pago-vuelto").val(vuelto);
                }
                return monto;
            }

            function limpiarCampos() {
                $(".articulos-listado").empty();
                $(".proveedor").val('');
                $(".pago-comentario").val('')
                $(".pago-efectivo").val('');
                $(".pago-debito").val('');
                $(".pago-credito").val('');
                $(".pago-cc").val('');
                $(".pago-otro").val('');
                $(".total-subtotal").val('');
                $(".total-descuento").val('');

                $(".total-descuento-porcentaje").val('')
                $(".total-descuento-monto").val('')
                $(".total-total").val('');
            }

        });
    </script>
@endsection
