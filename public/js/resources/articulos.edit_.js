$(document).ready(function() {

    // modal editar producto guardar 
    $(document).on('click', '.producto-guardar', async function() {
        var id = $(".editar-id").val();
        var nombre = $(".editar-articulo").val();
        var codigo = $(".editar-codigo").val();
        var categoria = $(".editar-categoria").val();
        // var cateogria_name = $.trim($(".editar-categoria option:selected").text());
        var marca = $(".editar-marca").val();
        // var marca_name = $.trim($(".editar-marca option:selected").text());
        var preciocosto = $(".editar-preciocompra").val();
        var precioventa = $(".editar-precioventa").val();
        var stock = $(".editar-stock").val();
        var stockminimo = $(".editar-stockminimo").val();
        // var habilitado = $(".editar-habilitado").prop('checked');
        var url = window.location.origin + window.location.pathname;


        var data = {
            id: id,
            nombre: nombre,
            codigo: codigo,
            categoria: categoria,
            marca: marca,
            preciocosto: preciocosto,
            precioventa: precioventa,
            stock: stock,
            stockminimo: stockminimo,
            // habilitado: habilitado
        }



        await $.ajax({
            type: "put",
            url: url,
            data: data,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == "success") {

                }
                if (response.errors) {
                    response.errors.forEach(element => {

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

                Toastify({
                    text: JSON.parse(response.responseText).message,
                    duration: 3000,
                    close: true,
                    //backgroundColor: "#4fbe87"
                }).showToast();
            }
        }); // ajax

    }); // on







});