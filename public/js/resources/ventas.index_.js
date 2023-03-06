$(document).ready(function() {

    $(document).on("change", ".filtro", function() {
        var url = window.location.origin + "/ventas/filtro";
        getdata(url);
    });
    $(document).on("click", " .pagination a", function(e) {
        e.preventDefault();
        var page = $(this).attr("href").split('page=')[1];
        getdata("ventas/filtro", page);
    });

    //  eliminar
    $(document).on("click", ".listado-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var monto = $(this).parent().parent().find(".recibido").attr("data-recibido");
        monto = parseFloat(monto).toFixed(2)
        var modopago = $(this).parent().parent().find(".modopago").attr("data-modopago");
        modopago = $.trim(modopago.toLowerCase())
        var url = window.location.origin + "/ventas-diarias/" + id + "/destroy";
        var data = {
            id: id
        }
        
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)

        var status = await Swal.fire({
            icon: "question",
            title: "Desea eliminar?",
            showCancelButton: true,
        })

        try {
            if (status.isConfirmed !== true && status.value !== true) {
                throw new Error("")
            }

            var res = await $.ajax({
                type: "delete",
                url: url,
                data: data,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === "success") {
                        $(thi).parent().parent().parent().parent().parent().remove();
                    }
                    if (response.status === "success" && response.message) {
                        msjAlert(response.message)
                    }
                    if (response.status === "error" && response.message) {
                        msjAlert(response.message, true)
                    }
                },
                error: function(response) {
                    msjAlert("Se produjo un error al eliminar", true)
                    // msjAlert(JSON.parse(response.responseText).message, true)
                }
            }); // ajax

           if( res.status === "success" && res.message === "Eliminado"){
                var cant_ventas = $.trim($(".cantidad_completas").html())
                cant_ventas = parseInt(cant_ventas  -1)
                $(".cantidad_completas").html(cant_ventas)
    
                if( modopago === "efectivo" ){
                    var actual = $.trim($(".monto_efectivo").html())
                    actual = parseFloat((actual - monto)).toFixed(2)
                    $(".monto_efectivo").html(actual)
        
                    var ingresos = $.trim($(".monto_completas").html())
                    actual = parseFloat((ingresos - monto)) .toFixed(2)
                    $(".monto_completas").html(actual)
    
                    var total = $.trim($(".total").html())
                    actual = parseFloat((total - monto)) .toFixed(2)
                    $(".monto_completas").html(actual)
                }
                if( modopago === "tarjeta debito" ){
                    var actual = $.trim($(".monto_debito").html())
                    actual = parseFloat((actual - monto)).toFixed(2)
                    $(".monto_debito").html(actual)
                }
                if( modopago === "efectivo pedidosya" ){
                    var actual = $.trim($(".monto_efectivo_pedidosya").html())
                    actual = parseFloat((actual - monto)).toFixed(2)
                    $(".monto_efectivo_pedidosya").html(actual)
        
                    var ingresos = $.trim($(".monto_completas").html())
                    actual = parseFloat((ingresos - monto)) .toFixed(2)
                    $(".monto_completas").html(actual)
                    
                    var total = $.trim($(".total").html())
                    actual = parseFloat((total - monto)) .toFixed(2)
                    $(".monto_completas").html(actual)
    
                }
                if( modopago === "credito pedidosya" ){
                    var actual = $.trim($(".monto_credito_pedidosya").html())
                    actual = parseFloat((actual - monto)).toFixed(2)
                    $(".monto_credito_pedidosya").html(actual)
                }
            }

        } catch (error) {
            $(thi).html('<i class="bi bi-trash"></i>')
        } finally {
            $(thi).html('<i class="bi bi-trash"></i>')

        }

    }); // eliminar

    // detalles
    $(document).on("click", ".listado-enviado", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var url = window.location.origin + "/ventas/enviado";
        var data = { id: id }

        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)

        try {
            await $.ajax({
                type: "put",
                url: url,
                data: data,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // beforeSend: function() {
                //     var span = ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
                //     $(".listado-articulos>tr").each(function(i, j) {
                //         var idd = $.trim($(this).find(".id").attr("data-id"));
                //         if (idd == id) {
                //             $(this).attr("disabled", "disabled");
                //             $(this).addClass("disabled");
                //             $(this).find(".listado-enviado").html(span);
                //             return true;
                //         }
                //     })
                // },
                success: function(response) {
                    if (response.status == "success") {
                        $(thi).parent().parent().find(".estado-envio").html("Enviado")
                        $(thi).remove();
                    }
                    if (response.status === "success" && response.message) {
                        msjAlert(response.message)
                    }
                    if (response.status === "error" && response.message) {
                        msjAlert(response.message, true)
                    }

                    // if (response.data) {
                    //     // $(".listado-articulos>tr").each(function(i, j) {
                    //     //     var id = $.trim($(this).find(".id").attr("data-id"));
                    //     //     if (id == response.data) {
                    //     //         $(this).find(".estado-envio").text("Enviado");
                    //     //         $(this).find(".listado-enviado").remove();
                    //     //         return false;
                    //     //     }
                    //     // })
                    // }

                }
            }); // ajax
        } catch (error) {
            $(thi).html('<i class="bi bi-check-all"></i>')
        } finally {
            $(thi).html('<i class="bi bi-check-all"></i>')

        }


    }); // detalles



    async function getdata(url, page = null) {
        var fecha_desde = $(".fecha_desde").val();
        var fecha_hasta = $(".fecha_hasta").val();
        var cliente = $(".cliente").val();
        var empleado = $(".empleado").val();
        var estadopago = $(".estadopago").val();

        var data = {
            fecha_desde: fecha_desde,
            fecha_hasta: fecha_hasta,
            cliente: cliente,
            empleado: empleado,
            estadopago: estadopago,
            page: page
        }

        await $.ajax({
            type: "get",
            url: url,
            data: data,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // var span = `<div id="loader active">
                //     <div class="spinner">
                //         <div class="rect1"></div>
                //         <div class="rect2"></div>
                //         <div class="rect3"></div>
                //         <div class="rect4"></div>
                //         <div class="rect5"></div>
                //     </div>
                // </div>`;
                // $("#tabla").html(span);
                var span = ` <tr>
                    <td colspan="17">
                        <div id="loader active">
                            <div class="spinner">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                                <div class="rect4"></div>
                                <div class="rect5"></div>
                            </div>
                        </div>
                    </td>
                </tr>`;
                $(".listado").html(span)
            },
            success: function(response) {
                if( $("#tabla")[0] ){
                    $("#tabla").html(response);
                }
            }

        });
    }





    function msjAlert(msj = '', error=false) {
        var color = "#3cb11f";
        if (error === true){ color = "#d73813";}
        Toastify({
            text: msj,
            duration: 5000,
            close: true,
            backgroundColor: color
        }).showToast();
    }


});