$(document).ready(function() {
    $(document).on("change", ".fecha", function() {
        botones_habilitar()
        calcularMonto()

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
        // $(".monto").val(subt);
        calcularMonto()
        botones_habilitar()


    });


    $(document).on("click", " .estado_pedido", function() {

        calcularMonto()
        botones_habilitar()

    });


    $(document).on("click", ".tipo_radio ", function() {
        botones_habilitar()

        // var total = $.trim($(".total-total").val()) ? parseFloat($(".total-total").val()) : 0;
        // total = total.toFixed(2)
        // $(".monto").val(total)

        calcularMonto()

    });

    $(document).on('click', '.venta-guardar', function() {
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(this).html(span)

        try {
            send(0);
        } catch (error) {
            $(this).html("Guardar")
            botones_deshabilitar()

        } finally {
            $(this).html("Guardar")
            botones_deshabilitar()

        }
    }); // click guardar venta



    $(document).on('click', '.venta-ticket', function() {
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(this).html(span)
        try {
            send(1);
        } catch (error) {
            $(this).html(' Guardar y generar ticket');
            botones_deshabilitar()


        } finally {
            $(this).html(' Guardar y generar ticket');
            botones_deshabilitar()
        }
    }); // click guardar venta



    async function send(ticket = 0) {
        var id = $(".venta-id").attr("data-id")
        var url = window.location.origin + "/ventas/edit/" + id + "/update";
        var monto = $.trim($(".monto").val())
        var pagos_id = $("input:radio[name=tipo_pago]:checked").val() ? $("input:radio[name=tipo_pago]:checked").val() : undefined

        if (monto > 0 && pagos_id == undefined) {
            msjAlert("Por favor seleccione un metodo de pago!", true)
            return false
        }

        var data = {
            "cliente": $.trim($(".cliente").val()),
            "pagos_id": pagos_id,
            "estadopedido_id": $("input:radio[name=estado_pedido]:checked").val(),
            "pagos_monto": monto,
            "fecha": $(".fecha").val(),
            "descuento": $.trim($(".total-descuento-monto").val()),
            "articulos": [],
            "comentario": $.trim($(".pago-comentario").val()),
            "ticket": ticket
        };

        // estado pedido
        // if ($("input:radio[name=estado_pedido]:checked").val() == undefined) {
        //     msjAlert("Seleccione un estado de pedido!", true)
        //     return false;
        // }

        // tipo pedido
        // if ($("input:radio[name=tipo_pago]:checked").val() == undefined) {
        //     Toastify({
        //         text: "Seleccione un tipo de pago!",
        //         duration: 3000,
        //         close: true,
        //         backgroundColor: "red"
        //     }).showToast();
        //     return false;
        // }



        $(".cantidad").each(function(i, j) {
            var articulo_id = $(this).parent().parent().find(".articulo-precio").attr("data-articuloid")
            var articulo_cantidad = $.trim($(this).val()) !== '' ? $.trim($(this).val()) : 0;
            if (articulo_cantidad !== 0) data.articulos.push({ articulo_id: articulo_id, articulo_cantidad: articulo_cantidad });
        });



        if (typeof(Storage) !== undefined && window.sessionStorage.getItem("notificaciones") != null) {
            window.sessionStorage.removeItem("notificaciones")
        }
        await $.ajax({
            type: "put",
            url: url,
            data: data,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // beforeSend: function() {
            //     // var span = ' <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span>  </div>';
            //     // if (ticket == false || ticket == 'false') {
            //     //     $(".venta-guardar").addClass("disabled");
            //     //     $(".venta-guardar").attr("disabled", "disabled");
            //     //     $(".venta-guardar").html(span);
            //     // }
            //     // if (ticket == true || ticket == 'true') {
            //     //     $(".venta-ticket").addClass("disabled");
            //     //     $(".venta-ticket").attr("disabled", "disabled");
            //     //     $(".venta-ticket").html(span);
            //     // }
            // },
            success: function(response) {

                if (response.status == "success" && response.message) {
                    msjAlert(response.message)
                }
                if (response.status == "error" && response.message) {
                    msjAlert(response.message, true)
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



    $(document).on("click", ".eliminar-pago", async function() {
        var thi = $(this)
        var id = $(this).attr("data-id");
        var venta = $(this).attr("data-venta");
        var url = window.location.origin + "/pagos/" + id + "/destroy";
        var data = {
            id: id,
            venta: venta
        }
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(this).html(span)

        var status = await Swal.fire({
            icon: "question",
            title: "Desea eliminar pago?",
            showCancelButton: true,
        })
        try {
            if (status.isConfirmed == true && status.value == true) {
                await $.ajax({
                    type: "delete",
                    url: url,
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == "success" && response.message) {
                            $(thi).parent().remove();
                            msjAlert(response.message)
                        }
                        if (response.status == "error" && response.message) {
                            msjAlert(response.message, true)
                        }
                    },
                    error: function(response) {
                        msjAlert(JSON.parse(response.responseText).message)

                    }
                }); // ajax
            }
        } catch (error) {
            $(thi).html("X")
        } finally {
            $(thi).html("X")

        }

    });



    function sumarSubtotales() {
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

    function calcularMonto() {
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