$(document).ready(function() {

    $(document).on("keyup", 'input, textarea', function() {
        habilitar()
    });

    $(document).on("change", 'select', function() {
        habilitar()
    });

    function habilitar() {
        $(".modal-stock-guardar").removeAttr("disabled");
        $(".editar-producto-guardar").removeAttr("disabled");
        $(".producto-guardar").removeAttr("disabled");

        $(".modal-stock-guardar").removeClass("disabled");
        $(".editar-producto-guardar ").removeClass("disabled");
        $(".producto-guardar ").removeClass("disabled");
    }

    function deshabilitar() {
        $(".modal-stock-guardar").attr("disabled", "disabled");
        $(".editar-producto-guardar").attr("disabled", "disabled");
        $(".producto-guardar").attr("disabled", "disabled");

        $(".modal-stock-guardar").addClass("disabled");
        $(".editar-producto-guardar").addClass("disabled");
        $(".producto-guardar").addClass("disabled");
    }

    // modal producto guardar 
    $(document).on('click', '.producto-guardar', async function() {
        var thi = $(this)
        var nombre = $.trim($(".producto-nombre").val()) ? $.trim($(".producto-nombre").val()) : undefined;
        var nombre_corto = $.trim($(".nombre_corto").val()) ? $.trim($(".nombre_corto").val()) : undefined
        var codigo = $.trim($(".producto-codigo").val());
        var categoria = $(".producto-categoria").val();
        var marca = $(".producto-marca").val();
        var preciocosto = $.trim($(".producto-preciocosto").val());
        var precioventa = $.trim($(".producto-precioventa").val());
        var stock = $.trim($(".producto-stock").val());
        var stockminimo = $.trim($(".producto-stockminimo").val())

        var data = {
            nombre: nombre,
            nombre_corto: nombre_corto,
            codigo: codigo,
            categoria: categoria,
            marca: marca,
            preciocosto: preciocosto,
            precioventa: precioventa,
            stock: stock,
            stockminimo: stockminimo,
        }

        if (nombre == undefined) {
            msjAlert("Ingresa un nombre de articulo", true)
            return false;
        }
        if (nombre_corto == undefined) {
            msjAlert("Ingresa un nombre corto de articulo", true)
            return false;
        }

        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)

        try {
            await $.ajax({
                type: "post",
                url: "articulos",
                data: data,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success" && response.data) {
                        $(".producto-nombre").val('');
                        $(".nombre_corto").val('');
                        $(".producto-codigo").val('');
                        $(".producto-categoria").val('');
                        $(".producto-marca").val('');
                        $(".producto-preciocosto").val('');
                        $(".producto-precioventa").val('');
                        $(".producto-stock").val('');
                        $(".producto-stockminimo").val('');
                        $("#nuevo-articulo").modal("hide");

                        var tr = `
                            <tr>
                                <td hidden class="listado-id" data-id="${response.data.id?response.data.id:''}">${response.data.id?response.data.id:''}</td>
                                <td class="listado-articulo text-start"> ${response.data.articulo?response.data.articulo:''} </td>
                                <td class="listado-nombre_corto text-start"> ${response.data.nombre_corto?response.data.nombre_corto:'' } </td>
                                <td data-label="Precio de Compra" class="listado-preciocompra text-end" data-preciocompra="${response.data.precio_compra?response.data.precio_compra:''}">${response.data.precio_compra?response.data.precio_compra:''} </td>
                                <td data-label="Precio de Venta" class="listado-precioventa text-end" data-precioventa="${response.data.precio_venta?response.data.precio_venta:''}">${response.data.precio_venta?response.data.precio_venta:''}</td>
                                <td data-label="Stock" class="listado-stock text-end" data-stock="${response.data.stock?response.data.stock:''}">${response.data.stock?response.data.stock:''}</td>
                                <td data-label="Stock minimo" class="listado-stockminimo text-end" data-stockminimo="${response.data.stock_minimo?response.data.stock_minimo:''}"> ${response.data.stock_minimo?response.data.stock_minimo:''} </td>
                                <td data-label="Categoria" class="listado-categoria" data-categoriaid="${response.data.categoria_id?response.data.categoria_id:''}"> ${response.data.categoria?response.data.categoria:'' } </td>
                                <td class="text-end">
                                    <button class="btn btn-success btn-sm listado-editar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar"  > <i class="bi bi-pencil"></i> </button>
                                    <button class="btn btn-success btn-sm listado-editar-stock mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Incrementar Stock" data-bs-original-title="Incrementar Stock"  > <i class="bi bi-box"></i> </button>
                                    <button class="btn btn-danger btn-sm listado-eliminar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i>  </button>
    
                                </td>
                            </tr>
                        `;

                        if ($(".productos-listado")[0]) $(".productos-listado").prepend(tr);
                        deshabilitar()
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

                }
            }); // ajax
        } catch (error) {
            $(thi).html("Guardar")
        } finally {
            $(thi).html("Guardar")
        }



    }); // on



    // editar stock 
    $(document).on("click", ".listado-editar-stock", function() {
        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var stock_actual = $(this).parent().parent().find(".listado-stock").attr("data-stock");
        var articulo = $.trim($(this).parent().parent().find(".listado-articulo").text()) ? $.trim($(this).parent().parent().find(".listado-articulo").text()) : "Incrementar stock de articulo";

        $(".modal-stock-id").val(id);
        $(".modal-stock-actual").val(stock_actual)
        $(".titulo").empty()
        $(".titulo").append(articulo)
        $("#modal-stock").modal("show");
    });
    // editar stock 


    // modal stock guardar
    $(document).on("click", ".modal-stock-guardar", async function() {
        var thi = $(this)
        var id = $.trim($(".modal-stock-id").val());
        var stock = $.trim($(".modal-stock-stock").val()) ? $.trim($(".modal-stock-stock").val()) : undefined;
        var url = window.location.origin + window.location.pathname + "/stock";
        var data = {
            id: id,
            stock: stock
        }

        if (stock == undefined || stock <= 0) {
            msjAlert("Ingrese stock", true)
            return false;
        }

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
                success: function(response) {
                    if (response.status == "success") {
                        if (response.data !== undefined) {
                            $(".productos-listado > tr").each(function(i, v) {
                                var id = $(v).find(".listado-id").attr(
                                    "data-id");
                                if (id == response.data.id) {
                                    $(v).find(".listado-stock").attr(
                                        "data-stock", response.data
                                        .stock_actual);
                                    $(v).find(".listado-stock").html(response
                                        .data.stock_actual);
                                    return false;
                                }
                            });
                        }
                        $("#modal-stock").modal("hide");
                    }
                    if (response.errors) {
                        response.errors.forEach(element => {
                            msjAlert(element)
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
                }
            }); // ajax
        } catch (error) {
            $(thi).html('Guardar')
        } finally {
            $(thi).html('Guardar')
            $(".modal-stock-stock").val('')
        }


    });
    // modal stock guardar


    // listado editar, poner datos en modal  al hacer click en editar
    $(document).on("click", ".listado-editar", function() {
        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var articulo = $.trim($(this).parent().parent().find(".listado-articulo").text());
        var nombre_corto = $.trim($(this).parent().parent().find(".listado-nombre_corto").text());
        var preciocompra = $(this).parent().parent().find(".listado-preciocompra").attr(
            "data-preciocompra");
        var precioventa = $(this).parent().parent().find(".listado-precioventa").attr(
            "data-precioventa");
        var stock = $(this).parent().parent().find(".listado-stock").attr("data-stock");
        var stockminimo = $(this).parent().parent().find(".listado-stockminimo").attr(
            "data-stockminimo");
        var marca_id = $(this).parent().parent().find(".listado-marca").attr("data-marcaid");
        var categoria_id = $(this).parent().parent().find(".listado-categoria").attr(
            "data-categoriaid");


        $(".modal-editar-id").val(id);
        $(".modal-editar-articulo").val(articulo)
        $(".modal-editar-nombre_corto").val(nombre_corto)
        $(".modal-editar-preciocompra").val(preciocompra);
        $(".modal-editar-precioventa").val(precioventa)
        $(".modal-editar-stock").val(stock)
        $(".modal-editar-stockminimo").val(stockminimo)
        $("#modal-editar-categoria").val(categoria_id)
        $(".modal-editar-marca").val(marca_id)
            // $(".modal-editar-categoria option[value="+ categoria_id+"]").attr("selected","selected") 


        $("#editar-articulo").modal("show");

    }); // listado editar




    // modal editar producto guardar 
    $(document).on('click', '.editar-producto-guardar', async function() {
        var thi = $(this)
        var id = $(".modal-editar-id").val();
        var nombre = $(".modal-editar-articulo").val();
        var nombre_corto = $(".modal-editar-nombre_corto").val();
        var codigo = $(".modal-editar-codigo").val();
        var categoria = $(".modal-editar-categoria").val();
        // var cateogria_name = $.trim($(".modal-editar-categoria option:selected").text());
        var marca = $(".modal-editar-marca").val();
        // var marca_name = $.trim($(".modal-editar-marca option:selected").text());
        var preciocosto = $(".modal-editar-preciocompra").val();
        var precioventa = $(".modal-editar-precioventa").val();
        var stock = $(".modal-editar-stock").val();
        var stockminimo = $(".modal-editar-stockminimo").val();
        var url = window.location.origin + "/articulos/" + id + "/editar";

        var data = {
            nombre: nombre,
            nombre_corto: nombre_corto,
            codigo: codigo,
            categoria: categoria,
            marca: marca,
            preciocosto: preciocosto,
            precioventa: precioventa,
            stock: stock,
            stockminimo: stockminimo,
        }

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
                success: function(response) {
                    if (response.status == "success") {

                        $(".modal-editar-id").val('');
                        $(".modal-editar-articulo").val('');
                        $(".modal-editar-nombre_corto").val('');
                        $(".modal-editar-codigo").val('');
                        $(".modal-editar-categoria").val('');
                        $(".modal-editar-marca").val('');
                        $(".modal-editar-preciocompra").val('');
                        $(".modal-editar-precioventa").val('');
                        $(".modal-editar-stock").val('');
                        $(".modal-editar-stockminimo").val('');
                        $(".modal-editar-habilitado").prop('checked');
                        $("#editar-articulo").modal("hide");

                        $(".productos-listado>tr").each(function() {
                            var id = $(this).find(".listado-id").attr("data-id");
                            if (id == response.data.id) {
                                $(this).find(".listado-articulo").text(response.data
                                    .articulo ? response.data.articulo : '');
                                $(this).find(".listado-nombre_corto").text(response.data
                                    .nombre_corto ? response.data.nombre_corto : '');
                                $(this).find(".listado-preciocompra").attr(
                                    "data-preciocompra", response.data
                                    .precio_compra ? response.data
                                    .precio_compra :
                                    '');
                                $(this).find(".listado-preciocompra").text(response
                                    .data
                                    .precio_compra ? response.data
                                    .precio_compra :
                                    '');

                                $(this).find(".listado-precioventa").attr(
                                    "data-precioventa", response.data
                                    .precio_venta ?
                                    response.data.precio_venta : '');
                                $(this).find(".listado-precioventa").text(response
                                    .data
                                    .precio_venta ? response.data.precio_venta :
                                    '');

                                $(this).find(".listado-stock").attr("data-stock",
                                    response.data.stock ? response.data.stock :
                                    '');
                                $(this).find(".listado-stock").text(response.data
                                    .stock ? response.data.stock : '');

                                $(this).find(".listado-stockminimo").attr(
                                    "data-stockminimo", response.data
                                    .stock_minimo ?
                                    response.data.stock_minimo : '');
                                $(this).find(".listado-stockminimo").html(response.data
                                    .stock_minimo ?
                                    response.data.stock_minimo : '');

                                $(this).find(".listado-marca").attr("data-marcaid",
                                    response.data.marca_id ? response.data
                                    .marca_id : '');
                                $(this).find(".listado-marca").text(response.data
                                    .marca ? response.data.marca : '');

                                $(this).find(".listado-categoria").attr(
                                    "data-categoriaid", response.data
                                    .categoria_id ?
                                    response.data.categoria_id : '');
                                $(this).find(".listado-categoria").text(response
                                    .data
                                    .categoria ? response.data.categoria :
                                    '');

                                if (response.data.habilitado == true || response
                                    .data.habilitado == "true") {
                                    $(this).find(".listado-habilitado").html(
                                        '<span class=" badge bg-success "> Habilitado</span>'
                                    );
                                } else {
                                    $(this).find(".listado-habilitado").html(
                                        '<span class=" badge bg-warning "> No habilitado</span>'
                                    );
                                }
                                return false;
                            }
                        });
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

                }
            }); // ajax
        } catch (error) {
            $(thi).html('Guardar')
        } finally {
            $(thi).html('Guardar')
        }


    }); // on





    $(document).on("click", ".listado-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var url = window.location.origin + "/articulos/" + id + "/delete";

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
                        if (response.errors) {
                            response.errors.forEach(element => {
                                msjAlert(element, true)

                            })
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
    }); // listado-eliminar


    $(document).on("change", ".filtro", function() {
        getdata();
    });
    $(document).on("click", " .pagination a", function(e) {
        e.preventDefault();
        var page = $(this).attr("href").split('page=')[1];

        getdata(page);
    });

    async function getdata(page = null) {
        var url = window.location.origin + "/articulos/filtro";
        var marca = $(".filtro-marca").val();
        var categoria = $(".filtro-categoria").val();
        var habilitado = $(".filtro-habilitado").val();

        var data = {
            marca: marca,
            categoria: categoria,
            habilitado: habilitado,
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
                if ($(".listado")[0]) $(".listado").html(span)
            },
            success: function(response) {
                $("#tabla").html(response);
            },
            error: function(response) {
                msjAlert(JSON.parse(response.responseText).message, true)
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