$(document).ready(function() {


    $(document).on("keyup", 'input, textarea', function() {
        // $(this).attr("data-key", true);
        habilitar()
    });

    $(document).on("keyup", ".edit-categoria", function() {
        $(this).attr("data-key", true);
    })


    function habilitar() {
        $(".modal-editar-guardar, .cliente-guardar").removeAttr("disabled");
        $(".modal-editar-guardar, .cliente-guardar").removeClass("disabled");
    }

    function deshabilitar() {

        $(".modal-editar-guardar, .cliente-guardar").attr("disabled", "disabled");
        $(".modal-editar-guardar, .cliente-guardar").addClass("disabled");

    }


    function limpiarCampos() {
        $(".cliente-nombre").val('');
        $(".cliente-identificacion").val('');
        $(".cliente-nroidentificacion").val('');
        $(".cliente-email").val('');
        $(".cliente-telefono").val('');
        $(".cliente-direccion").val('');
        $(".cliente-localidad").val('');

        $(".modal-editar-id").val('');
        $(".modal-editar-nombre").val('')
        $(".modal-editar-email").val('');
        $(".modal-editar-telefono").val('')
        $(".modal-editar-direccion").val('')
        $(".modal-editar-tipoidentificacion").val('')
        $(".modal-editar-dni").val('')
        $(".modal-editar-localidad").val('')
        $(".modal-editar-habilitado").val('')
    }

    // nuevo cliente modal
    $(document).on('click', '.cliente-guardar', async function() {
        var thi = $(this)
        var nombre = $.trim($(".cliente-nombre").val()) ? $.trim($(".cliente-nombre").val()) : undefined
        var identificacion = $(".cliente-identificacion").val();
        var nroidentificacion = $(".cliente-nroidentificacion").val();
        var email = $.trim($(".cliente-email").val())
        var telefono = $.trim($(".cliente-telefono").val())
        var direccion = $.trim($(".cliente-direccion").val())
        var localidad = $.trim($(".cliente-localidad").val())
            // var habilitado = $(".cliente-habilitado").prop('checked');

        var data = {
            nombre: nombre,
            identificacion: identificacion,
            nroidentificacion: nroidentificacion,
            email: email,
            telefono: telefono,
            direccion: direccion,
            localidad: localidad,
        }

        if (nombre == undefined) {
            msjAlert("Ingrese un nombre!", true)
            return false;
        }

        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)


        try {
            await $.ajax({
                type: "post",
                url: "clientes",
                data: data,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success" && response.data) {
                        // var habilitado =
                        //     `<span class="badge bg-warning"> no habilitado </span>`;
                        // if (response.data.habilitado) {
                        //     habilitado =
                        //         `<span class="badge bg-success"> habilitado </span>`;
                        // }
                        var tr = `
                            <tr>
                                <td class="listado-id" data-id="${response.data.id}" hidden> ${response.data.id }</td>
                                <td class="listado-nombre"> ${response.data.nombre?response.data.nombre:''}</td>
                                <td class="listado-email"> ${response.data.email?response.data.email:''} </td>
                                <td class="listado-telefono"> ${response.data.telefono?response.data.telefono:''} </td>
                                <td class="listado-direccion"> ${response.data.direccion?response.data.direccion:''} </td>
                                <td class="listado-dni" data-tipoidentificacionid="${response.data.tipo_identificacion_id?response.data.tipo_identificacion_id:i}"> ${response.data.nro_dni?response.data.nro_dni:''}</td>
                                <td class="listado-localidad"> ${response.data.localidad?response.data.localidad:''} </td>
                                 
                                <td class="text-end">
                                    <button class="btn btn-success btn-sm listado-editar  mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar"  >  <i class="bi bi-pencil"></i>  </button>
                                    <button class="btn btn-danger btn-sm listado-eliminar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i>     </button>
    
                                </td>
                            </tr>
                        `;

                        if ($(".listado")[0]) $(".listado").prepend(tr);
                        $("#nuevo-cliente").modal("hide");
                        limpiarCampos()
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
            deshabilitar()
        }
    }); // on




    // listado editar, poner datos en modal  al hacer click en editar
    $(document).on("click", ".listado-editar", function() {

        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var nombre = $.trim($(this).parent().parent().find(".listado-nombre").text());
        var email = $.trim($(this).parent().parent().find(".listado-email").text())
        var telefono = $.trim($(this).parent().parent().find(".listado-telefono").text())
        var direccion = $.trim($(this).parent().parent().find(".listado-direccion").text());
        var tipoidentificacionid = $(this).parent().parent().find(".listado-dni").attr(
            "data-tipoidentificacionid")
        var dni = $.trim($(this).parent().parent().find(".listado-dni").text())
        var localidad = $.trim($(this).parent().parent().find(".listado-localidad").text());
        // var habilitado = $(this).parent().parent().find(".listado-habilitado").attr(
        //     "data-habilitado");

        $(".modal-editar-id").val(id);
        $(".modal-editar-nombre").val(nombre)
        $(".modal-editar-email").val(email);
        $(".modal-editar-telefono").val(telefono)
        $(".modal-editar-direccion").val(direccion)
        $(".modal-editar-tipoidentificacion").val(tipoidentificacionid)
        $(".modal-editar-dni").val(dni)
        $(".modal-editar-localidad").val(localidad)
            // $(".modal-editar-habilitado").val(habilitado)

        // if (habilitado == true) {
        //     $(".modal-editar-habilitado").attr("checked", "checked")

        // } else {
        //     $(".modal-editar-habilitado").removeAttr("checked");
        // }

        $("#editar-cliente").modal("show");


    }); // listado editar




    // modal editar producto guardar 
    $(document).on('click', '.modal-editar-guardar', async function() {
        var thi = $(this)
        var id = $(".modal-editar-id").val();
        var nombre = $.trim($(".modal-editar-nombre").val()) ? $.trim($(".modal-editar-nombre").val()) : undefined
        var email = $.trim($(".modal-editar-email").val())
        var telefono = $.trim($(".modal-editar-telefono").val())
        var direccion = $.trim($(".modal-editar-direccion").val())
        var tipoidentificacion_id = $(".modal-editar-tipoidentificacion option:selected").val()
        var dni = $.trim($(".modal-editar-dni").val())
        var localidad = $.trim($(".modal-editar-localidad").val())

        var url = window.location.origin + window.location.pathname + "/" + id + "/editar";


        var data = {
            nombre: nombre,
            email: email,
            telefono: telefono,
            direccion: direccion,
            tipoidentificacion_id: tipoidentificacion_id,
            dni: dni,
            localidad: localidad,
        }

        if (nombre == undefined) {
            msjAlert("Ingrese un nombre", true)
            return false
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
                    if (response.status == "success" && response.data) {

                        $(".listado>tr").each(function() {
                            var idd = $(this).find(".listado-id").attr("data-id");
                            if (idd == response.data.id) {
                                $(this).find(".listado-nombre").text(response.data
                                    .nombre ? response.data.nombre : '');
                                $(this).find(".listado-email").text(response.data
                                    .email ? response.data.email : '');
                                $(this).find(".listado-telefono").text(response.data
                                    .telefono ? response.data.telefono : '');
                                $(this).find(".listado-direccion").text(response
                                    .data.direccion ? response.data.direccion :
                                    '');
                                $(this).find(".listado-dni").text(response.data
                                    .dni ? response.data.dni : '');
                                $(this).find(".listado-localidad").text(response
                                    .data.localidad ? response.data.localidad :
                                    '');

                                var habilitado =
                                    `<span class="badge bg-warning"> no habilitado </span>`;
                                if (response.data.habilitado) {
                                    habilitado =
                                        `<span class="badge bg-success"> habilitado </span>`;
                                }
                                $(this).find(".listado-habilitado").html(
                                    habilitado);
                                return false;
                            }
                        });

                        $("#editar-cliente").modal("hide");
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
            deshabilitar()
            limpiarCampos()
        }



    }); // on







    $(document).on("click", ".listado-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var url = window.location.origin + window.location.pathname + "/" + id + "/delete";
        console.log(url)
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

        $(thi).attr("disabled", "disabled")
        $(thi).addClass("disabled")

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
                            msjAlert(response.message)
                        }
                        if (response.status == "success") {
                            $(thi).parent().parent().remove();
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
            $(thi).html('<i class="bi bi-trash"></i>  ')
        } finally {
            $(thi).html('<i class="bi bi-trash"></i>  ')
            $(thi).removeAttr("disabled")
            $(thi).removeClass("disabled")
        }



    }); // listado-eliminar










    $(document).on("click", " .pagination a", function(e) {
        e.preventDefault();
        var page = $(this).attr("href").split('page=')[1];
        getdata(page);
    });


    async function getdata(page = null) {
        var url = window.location.origin + "/clientes/filtro";
        var data = {
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
                if ($("#tabla")[0]) $("#tabla").html(response);
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