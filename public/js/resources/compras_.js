$(document).ready(function() {

    $(document).on("change", ".filtro", function() {
        var url = "compras/filtro";
        getdata(url);
    });
    $(document).on("click", " .pagination a", function(e) {
        e.preventDefault();
        var page = $(this).attr("href").split('page=')[1];
        console.log(page)
        getdata("compras/filtro", page);
    });

    // eliminar
    $(document).on("click", ".destroy", async function() {
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var url = window.location.href + "/" + id + "/destroy";
        var data = {
            id: id
        }

        var status = await Swal.fire({
            icon: "question",
            title: "Desea eliminar?",
            showCancelButton: true,
        })

        console.log(status)
        if (status.isConfirmed == true && status.value == true) {
            $(this).parent().parent().remove();
            $.ajax({
                type: "delete",
                url: url,
                data: data,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response)

                    Toastify({
                        text: response.message,
                        duration: 3000,
                        close: true,
                        //backgroundColor: "#4fbe87"
                    }).showToast();
                },
                error: function(response) {
                    Toastify({
                        text: JSON.parse(response.responseText).message,
                        duration: 3000,
                        close: true,
                        //backgroundColor: "#4fbe87"
                    }).showToast();
                }
            }); // ajax

        }
    }); // on

    // detalles 
    $(document).on("click", ".listado-detalles", function() {
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var url = window.location.origin + window.location.pathname + "/" + id + "/show";
        var data = {}
        console.log(id)
        console.log(url)


        $.ajax({
            type: "get",
            url: url,
            data: data,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $(".modal-detalles").html(response);
                $("#detalles-compra").modal("show");
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


    function getdata(url, page = null) {
        var fecha_desde = $(".fecha_desde").val();
        var fecha_hasta = $(".fecha_hasta").val();
        var proveedor = $(".proveedor").val();
        var empleado = $(".empleado").val();
        var estadopago = $(".estadopago").val();

        var data = {
            fecha_desde: fecha_desde,
            fecha_hasta: fecha_hasta,
            proveedor: proveedor,
            estadopago: estadopago,
            page: page
        }

        $.ajax({
            type: "get",
            url: url,
            data: data,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $("#tabla").html(response);
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
    }

});