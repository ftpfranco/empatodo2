$(document).ready(function() {



    $(document).on("change", ".filtro", function() {
        getdata();

    });
    $(document).on("click", " .pagination a", function(e) {
        e.preventDefault();
        var page = $(this).attr("href").split('page=')[1];
        getdata(page);
    });



    //  eliminar
    $(document).on("click", ".listado-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var url = window.location.origin + "/ventas/" + id + "/destroy";
        var data = {
            id: id
        }
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(this).html(span)

        var status = await Swal.fire({
            icon: "question",
            title: "Desea eliminar?",
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
                        if (response.status == "success") {
                            $(thi).parent().parent().remove();
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

                    }
                }); // ajax

            }
        } catch (error) {
            $(thi).html('<i class="bi bi-trash"></i>')

        } finally {
            $(thi).html('<i class="bi bi-trash"></i>')

        }


    }); // eliminar

    // detalles
    $(document).on("click", ".listado-detalles", async function() {
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var url = window.location.origin + "/ventas/" + id + "/show";
        var data = {}
        await $.ajax({
            type: "get",
            url: url,
            data: data,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $(".modal-detalle").html(response);
                $("#detalles-venta").modal("show")

            }
        }); // ajax

    }); // detalles






    async function getdata(page = null) {
        var url = window.location.origin + "/listado/filtro";
        var fecha_desde = $(".fecha_desde").val();
        var fecha_hasta = $(".fecha_hasta").val();
        var cliente = $(".cliente").val();
        var empleado = $(".empleado").val();
        var estadopedido = $(".estadopedido").val();
        var tipopago = $(".tipopago").val();
        var estadopago = $(".estadopago").val();

        var data = {
            fecha_desde: fecha_desde,
            fecha_hasta: fecha_hasta,
            cliente: cliente,
            empleado: empleado,
            tipopago: tipopago,
            estadopedido: estadopedido,
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
                <td colspan="12">
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
                if ($(".listado")[0]) $(".listado").html(span)
            },
            success: function(response) {
                if ($("#tabla")[0]) $("#tabla").html(response[0]);
                $(".cantidad_completas").text(response[1].cantidad_completas)
                $(".monto_completas").text(response[1].monto_completas)
                $(".monto_credito").text(response[1].monto_credito)
                $(".monto_debito").text(response[1].monto_debito)
                $(".monto_egreso").text(response[1].monto_egreso)
                $(".total").text(response[1].total)
            }

        });
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