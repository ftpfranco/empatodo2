$(document).ready(function() {

    $(document).on("click", ".monto", function() {
        var monto = $(".total-total").val();
        $(".monto").val(monto);
    });
    // activar boton guardar
    $(document).on("change", ".proveedor,.fecha,.select-articulo", function() {
        $(".compra-guardar").removeAttr("disabled");
    });

    $(document).on("change", ".select-articulo", function() {
        botones_habilitar();
        var articulo_id = $(this).val();
        var articulo = $(this).text();
        var value = $(this).val();
        var arr = value.split("_");
        var id = arr[0];
        var stock = arr[1];
        var precio_venta = arr[2];
        var precio_compra = arr[3];


        var tr = `
            <tr>
                <td class="text-bold-500 articulo-id" data-id="${articulo_id}" hidden> ${articulo_id} </td>
                <td class="text-bold-500"> ${articulo?articulo:''} </td>
                <td>
                    <input type="number" class="form-control articulo-cantidad" value="1">
                </td>
                <td>
                    <input type="number" class="form-control precio-compra" value="${precio_compra?precio_compra:0}">
                </td>
                <td>
                    <input type="number" class="form-control precio-venta" value="${ precio_venta?precio_venta:0 }">
                </td>
                <td class="subtotal"> ${precio_compra?precio_compra:0}</td>
                <td>
                    <button class="btn btn-danger btn-sm articulo-eliminar mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >  <i class="bi bi-trash"></i>  </button>


                </td>
            </tr>
        `;
        $(".articulos-listado").append(tr);
        suma_subtotales();
    });

    // tipeo en cantidad articulo
    $(document).on("keyup", ".articulo-cantidad", function() {
        var cant = $(this).val();
        var precio_compra = $(this).parent().parent().find(".precio-compra").val();
        var sub = cant * precio_compra
        var sub = parseFloat(sub).toFixed(2);
        $(this).parent().parent().find(".subtotal").text(sub);
        suma_subtotales();
        $(".total-descuento-porcentaje").val('')
        $(".total-descuento-monto").val('')

    });
    // tipeo en cantidad articulo
    $(document).on("keyup", ".precio-compra", function() {
        var cant = $(this).parent().parent().find(".articulo-cantidad").val();
        var precio_compra = $(this).val();
        var sub = cant * precio_compra
        var sub = parseFloat(sub).toFixed(2);
        $(this).parent().parent().find(".subtotal").text(sub);
        suma_subtotales();
        $(".total-descuento-porcentaje").val('')
        $(".total-descuento-monto").val('')

    });


    $(document).on("keyup", '.pago-efectivo', function() {
        suma_pagos()
    });

    // function myFunction() {
    //     var str = 12.234556;
    //     str = str.toString().split('.');
    //     var res = str[1].slice(0, 2);
    //     document.getElementById("demo").innerHTML = str[0] + '.' + res;
    // }

    $(document).on("keyup", ".total-descuento-porcentaje", function() {
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
        $(this).parent().parent().remove();
        suma_subtotales();
        $(".total-descuento-porcentaje").val('')
        $(".total-descuento-monto").val('')
    });

    $(document).on('click', '.compra-guardar', function() {
        $(".compra-guardar").attr("disabled", "disabled");
        send();
    }); // click guardar venta


    function send() {
        var data = {
            "proveedor": $(".proveedor").val(),
            "pagos_id": $(".tipopago").val(),
            "pagos_monto": $(".monto").val(),
            "fecha": $(".fecha").val(),
            "articulos": {},
            "descuentos": {},
            // "pagos": {},
            "comentario": $(".pago-comentario").val(),
        };

        $(".articulos-listado>tr").each(function(i, j) {
            console.log(i)
            console.log($(this).val())
            var articulo_id = $(this).find('.articulo-id').attr("data-id").split("_")[0];
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
        });
        data.descuentos[0] = {
                "porcentaje": $(".total-descuento-porcentaje").val(),
                "monto": $(".total-descuento-monto").val()
            }
            // data.pagos[0] = {
            //     "efectivo": $(".pago-efectivo").val(),
            //     "debito": $(".pago-debito").val(),
            //     "credito": $(".pago-credito").val(),
            //     "cc": $(".pago-cc").val(),
            //     "otro": $(".pago-otro").val(),
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
                type: "post",
                url: "compras",
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

                        limpiarCampos();
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
        $(".subtotal").each(function() {
            sum += parseFloat($(this).text());
        });
        sum = sum.toFixed(2);
        $(".total-subtotal").val(sum);
        $(".total-total").val(sum);
        return sum;
    };

    function botones_habilitar() {
        $(".compra-guardar").removeAttr("disabled");
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