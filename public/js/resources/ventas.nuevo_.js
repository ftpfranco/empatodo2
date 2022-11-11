$(document).ready(function() {

    $(document).on("keyup", ".cliente, .total-subtotal, .total-descuento-monto, .total-total , .monto , .pago-comentario", function() {
        botones_habilitar()
    })
    $(document).on("keyup", ".cantidad", function() {
        var cant = $.trim($(this).val()) !== '' ? $.trim($(this).val()) : 0;
        var precio = $.trim($(this).parent().parent().find(".articulo-precio").val())
        var subtotal = 0;
        subtotal = parseFloat((precio * cant));
        // $(this).parent().parent().find(".cantidad").val(cant)
        sumarSubtotales()
        $(".total-descuento-porcentaje").val('');
        botones_habilitar()
        calcularMonto()
    });

    $(document).on("click", ".boton-incrementar", function() {
        var cant = $.trim($(this).parent().parent().find(".cantidad").val()) ? parseInt($.trim($(this).parent().parent().find(".cantidad").val())) : 0;
        var precio = $.trim($(this).parent().parent().find(".articulo-precio").val())
        var subtotal = 0;
        cant = ++cant;
        subtotal = parseFloat((precio * cant));

        $(this).parent().parent().find(".cantidad").val(cant)
        sumarSubtotales()
        $(".total-descuento-porcentaje").val('');
        botones_habilitar()
        calcularMonto()
    });

    $(document).on("click", ".boton-decrementar", function() {
        var cant = $.trim($(this).parent().parent().find(".cantidad").val()) ? parseInt($.trim($(this).parent().parent().find(".cantidad").val())) : 0;
        var precio = $.trim($(this).parent().parent().find(".articulo-precio").val())
        var subtotal = 0;
        cant = --cant
        if (cant >= 0) {
            subtotal = parseFloat((precio * cant));
            $(this).parent().parent().find(".cantidad").val(cant)
            sumarSubtotales()
        }
        $(".total-descuento-porcentaje").val('');
        botones_habilitar()
        calcularMonto()

    });



    $(document).on("keyup", ".total-descuento-monto", function() {
        // $(".total-descuento-porcentaje").val(0);
        var descuento = ($(this).val() == undefined || $(this).val() == '') ? 0 : $(this).val();
        var total = 0;

        $(".cantidad").each(function(i, j) {
            var cant = $.trim($(this).val()) !== '' ? $.trim($(j).val()) : 0;
            var precio = $.trim($(this).parent().parent().find(".articulo-precio").val())
            if (cant !== 0) {
                total += parseFloat(cant * precio)
            }
        });

        var subt = total - descuento;
        if (descuento > 0) {
            var porcentaje = descuento * (100 / total);
            $(".total-descuento-porcentaje").val(porcentaje.toFixed(2));
        }

        subt = parseFloat(subt).toFixed(2);
        $(".total-total").val(subt);
        $(".monto").val(subt);
    });


    $(document).on("click", " .estado_pedido", function() {

        botones_habilitar()
        calcularMonto()
    });


    $(document).on("click", ".tipo_radio ", function() {
        botones_habilitar()
        calcularMonto()

        var total = $.trim($(".total-total").val()) ? parseFloat($(".total-total").val()) : 0;
        total = total.toFixed(2)
        $(".monto").val(total)
    });

    $(document).on('click', '.venta-guardar', async function() {
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(this).html(span)
        botones_deshabilitar()

        try {
            await send(0);
        } catch (error) {
            $(this).html("Guardar")

        } finally {
            $(this).html("Guardar")

        }
    }); // click guardar venta


    $(document).on('click', '.venta-ticket', async function() {
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(this).html(span)
        botones_deshabilitar()

        try {
            await send(1);
        } catch (error) {
            $(this).html(' Guardar y generar ticket');

        } finally {
            $(this).html(' Guardar y generar ticket');
        }
    }); // click guardar venta



    async function send(ticket) {
        var data = {
            "cliente": $.trim($(".cliente").val()),
            "envio": $(".tipoenvio").val(),
            "pagos_id": $("input:radio[name=tipo_pago]:checked").val(),
            "pagos_monto": $.trim($(".monto").val()),
            "fecha": $(".fecha").val(),
            "descuento": $.trim($(".total-descuento-monto").val()),
            "articulos": [],
            "comentario": $.trim($(".pago-comentario").val()),
            "ticket": ticket
        };

        // if ($("input:radio[name=tipo_pago]:checked").val() == undefined) {
        //     Toastify({
        //         text: "Seleccione un metodo de pago!",
        //         duration: 3000,
        //         close: true,
        //         backgroundColor: "red"
        //     }).showToast();
        //     return false;
        // }


        await $(".cantidad").each(function(i, j) {
            var articulo_id = $(this).parent().parent().find(".articulo-precio").attr("data-articuloid");
            var articulo_cantidad = $.trim($(this).val()) !== '' ? $.trim($(this).val()) : 0;
            if (articulo_cantidad !== 0)
                data.articulos.push({ articulo_id: articulo_id, articulo_cantidad: articulo_cantidad });
        });



        if (typeof(Storage) !== undefined && window.sessionStorage.getItem("notificaciones") != null) {
            window.sessionStorage.removeItem("notificaciones")
        }
        var url = window.location.origin + "/ventas/ventas"
        await $.ajax({
            type: "post",
            url: url,
            data: data,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // beforeSend: function() {
            //     var span = ' <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span>  </div>';
            //     if (ticket == false || ticket == 'false') {
            //         $(".venta-guardar").addClass("disabled");
            //         $(".venta-guardar").attr("disabled", "disabled");
            //         $(".venta-guardar").html(span);
            //     }
            //     if (ticket == true || ticket == 'true') {
            //         $(".venta-ticket").addClass("disabled");
            //         $(".venta-ticket").attr("disabled", "disabled");
            //         $(".venta-ticket").html(span);
            //     }
            // },
            success: function(response) {
                if (response.status == "success") {
                    limpiarCampos();
                }
                if (response.data) {
                    var bytes = atob(response.data);
                    let length = bytes.length;
                    let out = new Uint8Array(length);

                    while (length--) {
                        out[length] = bytes.charCodeAt(length);
                    }

                    var blob = new Blob([out], {
                        type: 'application/pdf'
                    });

                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Comprobante.pdf";
                    link.click();
                }
                if (response.errors) {
                    response.errors.forEach(element => {
                        msjAlert(element, true)
                    })
                }
                if (response.status == "success" && response.message) {
                    msjAlert(response.message)
                }
                if (response.status == "error" && response.message) {
                    msjAlert(response.message, true)
                }
            },
            error: function(response) {
                msjAlert(JSON.parse(response.responseText).message, true)
            },
            // complete: function() {
            //     $(".venta-guardar").addClass('disabled');
            //     $(".venta-guardar").attr('disabled', 'disabled');
            //     $(".venta-ticket").addClass('disabled');
            //     $(".venta-ticket").attr('disabled', 'disabled');
            //     $(".venta-guardar").html('Guardar');
            //     $(".venta-ticket").html(' Guardar y generar ticket');
            // },
        }); // ajax
    } // end send


    async function calcularMonto() {
        var total = $.trim($(".total-total").val());
        var pago_anterior = 0;
        $(".pago-anterior").each(function(k, v) {
            var monto = $.trim($(this).attr("data-monto"))
            pago_anterior += parseFloat(monto)
        });
        var resultado = parseFloat(total - pago_anterior);
        $(".monto").val(resultado)
        $(".calcular-monto").text(total + " - " + pago_anterior + " = " + resultado);
    }

    async function sumarSubtotales() {
        var total = 0;
        var descuento = $.trim($(".total-descuento-monto").val()) !== '' ? parseFloat($.trim($(".total-descuento-monto").val())) : 0;

        $(".cantidad").each(function(i, j) {
            var cant = $.trim($(this).val()) !== '' ? $.trim($(j).val()) : 0;
            var precio = $.trim($(this).parent().parent().find(".articulo-precio").val())
            if (cant !== 0) {
                total += parseFloat(cant * precio)
            }
        });

        $(".total-subtotal").val(total);
        total = parseFloat(total - descuento)
        $(".total-total").val(total);
        // $(".monto").val(total);

        return total;
    }

    function botones_habilitar() {
        $(".venta-guardar").removeAttr("disabled");
        $(".venta-factura").removeAttr("disabled");
        $(".venta-ticket").removeAttr("disabled");

        $(".venta-guardar").removeClass("disabled");
        $(".venta-factura").removeClass("disabled");
        $(".venta-ticket").removeClass("disabled");

    }

    function botones_deshabilitar() {
        $(".venta-guardar").attr("disabled", "disabled");
        $(".venta-ticket").attr("disabled", "disabled");

        $(".venta-guardar").addClass("disabled");
        $(".venta-ticket").addClass("disabled");

    }


    function limpiarCampos() {
        $(".articulos-listado").empty();
        $(".select-articulo").val(-1);
        $(".cliente").val('');
        $(".monto").val('');
        $(".pago-comentario").val('')
        $(".tipoenvio").val(-1)
        $(".total-subtotal").val('');
        $(".total-descuento").val('');
        $(".cantidad").val('')

        $(".total-descuento-porcentaje").val('')
        $(".total-descuento-monto").val('')
        $(".total-total").val('');
        $("input[type=radio]").prop("checked", false)
    }


    function msjAlert(msj = '', error) {
        var color = "#3cb11f";
        if (error == true) color = "#d73813";
        Toastify({
            text: msj,
            duration: 5000,
            close: true,
            backgroundColor: color
        }).showToast();
    }


});