$(document).ready(function() {

    $(document).on("click", ".abrir-modal-nuevo", function() {
        $(".modal-nuevo-email").val("");
        $(".modal-nuevo-password").val("");
        $("#nuevo-empleado").modal("show");
    });

    // nuevo empleado modal
    $(document).on('click', '.modal-nuevo-guardar', async function() {
        var th = $(this)

        var nombre = $.trim($(".modal-nuevo-nombre").val()) ? $.trim($(".modal-nuevo-nombre").val()) : undefined
        var identificacion = $(".modal-nuevo-identificacion").val();
        // var nroidentificacion = $.trim($(".modal-nuevo-nroidentificacion").val())
        var email = $.trim($(".modal-nuevo-email").val()) ? $.trim($(".modal-nuevo-email").val()) : undefined
        var password = $.trim($(".modal-nuevo-password").val()) ? $.trim($(".modal-nuevo-password").val()) : undefined
        var time1_start = $("#nuevo-empleado").find(".t1-start").val() ? $("#nuevo-empleado").find(".t1-start").val() : undefined
        var time1_end = $("#nuevo-empleado").find(".t1-end").val() ? $("#nuevo-empleado").find(".t1-end").val() : undefined
        var time2_start = $("#nuevo-empleado").find(".t2-start").val() ? $("#nuevo-empleado").find(".t2-start").val() : undefined
        var time2_end = $("#nuevo-empleado").find(".t2-end").val() ? $("#nuevo-empleado").find(".t2-end").val() : undefined
        var telefono = $.trim($(".modal-nuevo-telefono").val())
        var direccion = $.trim($(".modal-nuevo-direccion").val())
        var localidad = $.trim($(".modal-nuevo-localidad").val())
        var habilitado = $(".modal-nuevo-habilitado").prop('checked');
        var url = window.location.origin + window.location.pathname;

        if (nombre === undefined) {
            msjAlert("Por favor ingresa un nombre !", true)
            return false
        }
        if (email === undefined) {
            msjAlert("Por favor ingresa un mail válido!", true)
            return false
        }
        if ((time1_start == undefined && time1_end == undefined) && (time2_start == undefined && time2_end == undefined)) {
            msjAlert("Ingresa al menos un horario laboral!", true)
            return false
        }

        var data = {
            nombre: nombre,
            identificacion: identificacion,
            // nroidentificacion: nroidentificacion,
            email: email,
            password: password,
            time1_start: time1_start,
            time1_end: time1_end,
            time2_start: time2_start,
            time2_end: time2_end,
            telefono: telefono,
            direccion: direccion,
            localidad: localidad,
            habilitado: habilitado
        }
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(th).html(span)


        try {
            await $.ajax({
                type: "post",
                url: url,
                data: data,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success" && response.data) {
                        if ($(".listado")[0] == undefined) {
                            var trr = `
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Mail</th>
                                                <th>Horarios</th>
                                                <th>Telefono</th>
                                                <th>Dni</th>
                                                <th>Direccion</th>
                                                <th>Localidad</th>
                                                <th>Habilitado</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="listado" id="listado"> </tbody>
                                    </table>
                                </div>`

                            $("#tabla").empty()
                            $("#tabla").append(trr)
                        }
                        var habilitado =
                            `<span class="badge bg-warning"> no habilitado </span>`;
                        if (response.data.habilitado == "true") {
                            habilitado =
                                `<span class="badge bg-success"> habilitado </span>`;
                        }
                        var tr = `
                            <tr>
                                <td class="listado-id" data-id="${response.data.id}" hidden> ${response.data.id }</td>
                                <td class="listado-nombre"> ${response.data.nombre?response.data.nombre:''}</td>
                                <td class="listado-email"> ${response.data.email?response.data.email:''} </td>
                                <td class="listado-horarios"> ${response.data.horarios?response.data.horarios:''} </td>
                                <td class="listado-horarios-t1-start" hidden> ${response.data.time1_start?response.data.time1_start:''} </td>
                                <td class="listado-horarios-t1-end" hidden> ${response.data.time1_end?response.data.time1_end:''} </td>
                                <td class="listado-horarios-t2-start" hidden> ${response.data.time2_start?response.data.time2_start:''} </td>
                                <td class="listado-horarios-t2-end" hidden> ${response.data.time2_end?response.data.time2_end:''} </td>
                                <td class="listado-telefono"> ${response.data.telefono?response.data.telefono:''} </td>
                                <td class="listado-direccion"> ${response.data.direccion?response.data.direccion:''} </td>
                                <td class="listado-dni" data-tipoidentificacionid="${response.data.tipo_identificacion_id?response.data.tipo_identificacion_id:i}"> ${response.data.nro_dni?response.data.nro_dni:''}</td>
                                <td class="listado-localidad"> ${response.data.localidad?response.data.localidad:''} </td>
                                <td class="listado-habilitado" data-habilitado="${response.data.habilitado?response.data.habilitado:''}">
                                    ${habilitado}
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm listado-editar mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar" >   <i class="bi bi-pencil"></i>  </button>
                                    <button class="btn btn-danger btn-sm listado-eliminar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >  <i class="bi bi-trash"></i>  </button>

                                </td>
                            </tr>
                        `;

                        $(".listado").prepend(tr);
                        $("#nuevo-empleado").modal("hide");
                    }
                    if (response.errors) {
                        response.errors.forEach(element => {
                            msjAlert(element, true)
                        })
                    }
                    if (response.status == "success" && response.message) {
                        msjAlert(response.message)
                        $(".modal-nuevo-nombre").val('');
                        // $(".modal-nuevo-identificacion").val('');
                        $(".modal-nuevo-nroidentificacion").val('');
                        $(".modal-nuevo-email").val('');
                        $(".modal-nuevo-password").val('');
                        $(".modal-nuevo-telefono").val('');
                        $(".modal-nuevo-direccion").val('');
                        $(".modal-nuevo-localidad").val('');
                        $(".modal-nuevo-localidad").val('');
                        $("#nuevo-empleado").find(".t1-start").val('')
                        $("#nuevo-empleado").find(".t1-end").val('')
                        $("#nuevo-empleado").find(".t2-start").val('')
                        $("#nuevo-empleado").find(".t2-end").val('')
                    }
                    if (response.status == "error" && response.message) {
                        msjAlert(response.message, true)
                    }
                },
                error: function(response) {
                    msjAlert("Error", true)
                }
            }); // ajax

        } catch (error) {

        } finally {
            $(th).html("Guardar")
        }


    }); // on




    // listado editar, poner datos en modal  al hacer click en editar
    $(document).on("click", ".listado-editar", async function() {
        var th = $(this)
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(th).html(span)

        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var nombre = $.trim($(this).parent().parent().find(".listado-nombre").text());
        var email = $.trim($(this).parent().parent().find(".listado-email").text())
        var telefono = $.trim($(this).parent().parent().find(".listado-telefono").text())
        var direccion = $.trim($(this).parent().parent().find(".listado-direccion").text());
        var tipoidentificacionid = $(this).parent().parent().find(".listado-dni").attr(
            "data-tipoidentificacionid")
        var dni = $.trim($(this).parent().parent().find(".listado-dni").text())
        var localidad = $.trim($(this).parent().parent().find(".listado-localidad").text());
        var habilitado = $(this).parent().parent().find(".listado-habilitado").attr(
            "data-habilitado");

        // var t1_start = $.trim($(th).parent().parent().find(".listado-horarios-t1-start").text())
        // var t1_end = $.trim($(th).parent().parent().find(".listado-horarios-t1-end").text())

        // var t2_start = $.trim($(th).parent().parent().find(".listado-horarios-t2-start").text())
        // var t2_end = $.trim($(th).parent().parent().find(".listado-horarios-t2-end").text())

        $("#editar-empleado").find("input").val('')
        $(".modal-editar-id").val(id);
        $(".modal-editar-nombre").val(nombre)
        $(".modal-editar-email").attr("placeholder", email);
        $(".modal-editar-telefono").val(telefono)
        $(".modal-editar-direccion").val(direccion)
        $(".modal-editar-tipoidentificacion").val(tipoidentificacionid)
        $(".modal-editar-dni").val(dni)
        $(".modal-editar-localidad").val(localidad)
        $(".modal-editar-habilitado").val(habilitado)
            // $("#editar-empleado").find(".t1-start").val(t1_start)
            // $("#editar-empleado").find(".t1-end").val(t1_end)
            // $("#editar-empleado").find(".t2-start").val(t2_start)
            // $("#editar-empleado").find(".t2-end").val(t2_end)

        if (habilitado == true || habilitado == 1) {
            // $(".modal-editar-habilitado").attr("checked", "checked")
            $(".modal-editar-habilitado").prop("checked", true)

        } else {
            // $(".modal-editar-habilitado").removeAttr("checked");
            $(".modal-editar-habilitado").prop("checked", false)

        }

        // traer turnos 
        var data = { empleado_id: id }
        var url = window.location.origin + "/userhorarios";
        try {
            await $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success" && response.data) {
                        if (response.data.time1_start) $("#editar-empleado").find(".t1-start").val(response.data.time1_start)
                        if (response.data.time1_end) $("#editar-empleado").find(".t1-end").val(response.data.time1_end)
                        if (response.data.time2_start) $("#editar-empleado").find(".t2-start").val(response.data.time2_start)
                        if (response.data.time2_end) $("#editar-empleado").find(".t2-end").val(response.data.time2_end)
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
                    msjAlert("Error", true)

                }
            }); // ajax 
        } catch (error) {

        } finally {
            $(th).html('<i class="bi bi-pencil"></i> ')
        }

        // end traer turnos 
        $("#editar-empleado").modal("show");


    }); // listado editar


    // modal editar empleado guardar 
    $(document).on('click', '.modal-editar-guardar', async function() {
        var th = $(this)
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(th).html(span)

        var id = $(".modal-editar-id").val();
        var nombre = $(".modal-editar-nombre").val()
        var email = $(".modal-editar-email").val();
        var password = $(".modal-editar-password").val();
        var telefono = $(".modal-editar-telefono").val()
        var direccion = $(".modal-editar-direccion").val()
        var tipoidentificacion_id = $(".modal-editar-tipoidentificacion option:selected").val()
        var dni = $(".modal-editar-dni").val()
        var localidad = $(".modal-editar-localidad").val()
        var habilitado = $(".modal-editar-habilitado").prop('checked');

        var t1_start = $("#editar-empleado").find(".t1-start").val()
        var t1_end = $("#editar-empleado").find(".t1-end").val()
        var t2_start = $("#editar-empleado").find(".t2-start").val()
        var t2_end = $("#editar-empleado").find(".t2-end").val()

        var url = window.location.origin + window.location.pathname + "/" + id + "/editar";

        var data = {
            nombre: nombre,
            email: email,
            password: password,
            time1_start: t1_start,
            time1_end: t1_end,
            time2_start: t2_start,
            time2_end: t2_end,
            telefono: telefono,
            direccion: direccion,
            tipoidentificacion_id: tipoidentificacion_id,
            dni: dni,
            localidad: localidad,
            habilitado: habilitado
        }


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
                        $(".listado>tr").each(function() {
                            var idd = $(this).find(".listado-id").attr("data-id");
                            if (idd == response.data.id) {
                                if (response.data.nombre) $(this).find(".listado-nombre").text(response.data.nombre);
                                if (response.data.email) $(this).find(".listado-email").text(response.data.email);
                                if (response.data.telefono) $(this).find(".listado-telefono").text(response.data.telefono);
                                if (response.data.direccion) $(this).find(".listado-direccion").text(response.data.direccion);
                                if (response.data.dni) $(this).find(".listado-dni").text(response.data.dni);
                                if (response.data.localidad) $(this).find(".listado-localidad").text(response.data.localidad);
                                if (response.data.horarios) $(this).find(".listado-horarios").text(response.data.horarios)
                                if (response.data.time1_start) $(this).find(".listado-horarios-t1-start").text(response.data.time1_start)
                                if (response.data.time1_end) $(this).find(".listado-horarios-t1-end").text(response.data.time1_end)
                                if (response.data.time2_start) $(this).find(".listado-horarios-t2-start").text(response.data.time2_start)
                                if (response.data.time2_end) $(this).find(".listado-horarios-t2-end").text(response.data.time2_end)

                                var habilitado = `<span class="badge bg-warning"> no habilitado </span>`;
                                if (response.data.habilitado == "true" || response.data.habilitado == true) {
                                    habilitado = `<span class="badge bg-success"> habilitado </span>`;
                                    $(this).find(".listado-habilitado").attr("data-habilitado", 1);
                                } else {
                                    $(this).find(".listado-habilitado").attr("data-habilitado", 0);
                                }
                                $(this).find(".listado-habilitado").html(habilitado);


                                return false;
                            }
                        });

                        $("#editar-empleado").modal("hide");
                    }

                    if (response.errors) {
                        response.errors.forEach(element => {
                            msjAlert(element, true)
                        })
                    }
                    if (response.status == "success" && response.message) {
                        msjAlert(response.message)
                        $("#editar-empleado").find("input").val('')

                    }
                    if (response.status == "error" && response.message) {
                        msjAlert(response.message, true)
                    }
                },
                error: function(response) {
                    msjAlert("Error", true)

                }
            }); // ajax
        } catch (error) {

        } finally {
            $(th).html("Guardar")

        }


    }); // on







    $(document).on("click", ".listado-eliminar", async function() {
        var th = $(this)
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(th).html(span)

        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var url = window.location.origin + window.location.pathname + "/" + id + "/delete";
        var data = {
            id: id
        }

        var status = await Swal.fire({
            icon: "question",
            title: "Desea eliminar?",
            showCancelButton: true,
        })

        try {
            if (status.isConfirmed == true && status.value == true) {
                $(this).parent().parent().remove();
                await $.ajax({
                    type: "delete",
                    url: url,
                    data: data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
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
                        msjAlert("Error", true)
                    }

                }); // ajax

            }
        } catch (error) {

        } finally {
            $(th).html('<i class="bi bi-trash"></i>')
        }

    }); // listado-eliminar










    $(document).on("click", " .pagination a", async function(e) {
        e.preventDefault();
        var page = $(this).attr("href").split('page=')[1];
        await getdata(page);
    });


    function getdata(page = null) {
        var url = window.location.origin + window.location.pathname + "/filtro";
        var data = {
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
                if ($("#tabla")[0]) {
                    $("#tabla").html(response);
                }
            },
            error: function(response) {
                msjAlert("Error", true)
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