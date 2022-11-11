$(document).ready(function() {

    $(document).on("keyup", "input,textarea ", function() {
        habilitar()
    });

    $(document).on("change", "input,textarea,select", function() {
        habilitar()
    })

    function habilitar() {
        $(".modal-nuevo-guardar, .modal-editar-guardar").removeAttr("disabled");
        $(".modal-nuevo-guardar, .modal-editar-guardar").removeClass("disabled");

        $(".modal-editar-guardar, .modal-editar-guardar").removeAttr("disabled");
        $(".modal-editar-guardar, .modal-editar-guardar").removeClass("disabled");
    }

    // modal  gasto nuevo guardar
    $(document).on("click", ".modal-nuevo-guardar", async function() {
        var thi = $(this)
        var fecha = $(".modal-nuevo-fecha").val();
        var gastotipo = $(".modal-nuevo-gastotipo").val() !== "-1" ? $(".modal-nuevo-gastotipo").val() : undefined
        var monto = $.trim($(".modal-nuevo-monto").val()) ? $.trim($(".modal-nuevo-monto").val()) : undefined;
        var comentario = $.trim($(".modal-nuevo-comentario").val());
        var url = window.location.origin + window.location.pathname;

        var data = {
            fecha: fecha,
            gastotipo: gastotipo,
            monto: monto,
            comentario: comentario
        }

        if (gastotipo == undefined) { msjAlert("Selecciona una Categoria", true); return false }
        if (monto == undefined) { msjAlert("Ingresa un monto", true); return false }

        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)


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

                    if (response.status == "success") {
                        $("#gasto-nuevo").modal("hide");
                        $(".modal-nuevo-fecha").val('');
                        $(".modal-nuevo-gastotipo").val('-1');
                        $(".modal-nuevo-monto").val('');
                        $(".modal-nuevo-comentario").val('');
                    }
                    if (response.status == "error" && response.message) {
                        msjAlert(response.message, true)
                    }
                    if (response.status == "success" && response.message) {
                        msjAlert(response.message)
                    }
                    if (response.status == "success" && response.data) {
                        if ($(".listado")[0] == undefined) {
                            var trr = `
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th> Hora  </th>
                                                <th>Tipo</th>
                                                <th>Monto</th>
                                                <th>Comentario</th>
                                                <th class="text-end">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="listado"> </tbody>
                                    </table>
                                </div>
                                `
                            $("#tabla").empty()
                            $("#tabla").append(trr)
                        }

                        var tr =
                            ` <tr>
                                <td hidden class="listado-id" data-id="${response.data.id}"> </td>
                                <td data-label="${response.data.fecha?'Fecha':'Hora'}" class="listado-fecha" data-fecha="${response.data.fecha?response.data.fecha:''}">  <small>  ${response.data.hora?response.data.hora:''} </small></td>
                                <td data-label="Categoria" class="listado-gastotipo text-bold-500 " data-gastotipoid="${response.data.gastotipo_id?response.data.gastotipo_id:''}">${response.data.gastotipo?response.data.gastotipo:''}</td>
                                <td data-label="Monto" class="listado-monto" data-monto="${response.data.monto}"> ${response.data.monto?response.data.monto:''} </td>
                                <td data-label="Comentario" class="listado-comentario text-bold-500">  ${response.data.comentario?response.data.comentario:''} </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-success btn-sm listado-editar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar" > <i class="bi bi-pencil"></i> </button>
                                    <button type="button" class="btn btn-danger btn-sm listado-eliminar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >   <i class="bi bi-trash"></i>    </button>
                                </td>
                            </tr>
                            `;

                        $(".listado").prepend(tr);

                        var monto = $(".resumen-total").attr("data-monto");
                        var total = parseFloat(monto) + parseFloat(response.data.monto);
                        total = parseFloat(total).toFixed(2);
                        $(".resumen-total").attr("data-monto", total);
                        $(".resumen-total").text(total);
                        var cantidad = $(".resumen-cantidad").attr("data-cantidad")
                        var can_tot = parseInt(cantidad) + 1;
                        $(".resumen-cantidad").attr("data-cantidad", can_tot)
                        $(".resumen-cantidad").html(can_tot)

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
        } catch (error) {
            $(thi).html("Guardar")
        } finally {
            $(thi).html("Guardar")
        }





    });


    $(document).on("click", ".listado-editar", function() {
        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var fecha = $(this).parent().parent().find(".listado-fecha").attr("data-fecha");
        var gastotipo_id = $(this).parent().parent().find(".listado-gastotipo").attr(
            "data-gastotipoid");
        var monto = $(this).parent().parent().find(".listado-monto").attr("data-monto");
        var comentario = $.trim($(this).parent().parent().find(".listado-comentario").text());

        $(".modal-editar-id").val(id);
        $(".modal-editar-fecha").val(fecha);
        $(".modal-editar-gastotipo").val(gastotipo_id)
        $(".modal-editar-monto").val(monto);
        $(".modal-editar-monto").attr("data-monto", monto);
        $(".modal-editar-comentario").val(comentario);

        $("#gasto-editar").modal("show")
    });

    $(document).on("click", ".modal-editar-guardar", async function() {
        var thi = $(this)
        var url = window.location.origin + "/egresos";
        var id = $(".modal-editar-id").val();
        var fecha = $(".modal-editar-fecha").val();
        var gastotipo = $(".modal-editar-gastotipo").val() !== "-1" ? $(".modal-editar-gastotipo").val() : undefined
        var monto = $.trim($(".modal-editar-monto").val()) ? $(".modal-editar-monto").val() : undefined;
        var monto_anterior = $(".modal-editar-monto").attr("data-monto");
        var comentario = $.trim($(".modal-editar-comentario").val());

        var data = {
            id: id,
            fecha: fecha,
            gastotipo: gastotipo,
            monto: monto,
            comentario: comentario
        }

        if (gastotipo == undefined) {
            msjAlert("Selecciona una Categoria  ", true)
            return false;
        }
        if (monto == undefined) {
            msjAlert("Ingresa un monto", true)
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
                        $("#gasto-editar").modal("hide");
                    }
                    if (response.status == "success" && response.message) {
                        msjAlert(response.message)
                    }
                    if (response.status == "error" && response.message) {
                        msjAlert(response.message, true)
                    }
                    if (response.data) {
                        $(".listado>tr").each(function() {
                            var id = $(this).find(".listado-id").attr("data-id");
                            if (id === response.data.id) {
                                $(this).find(".listado-fecha").attr("data-fecha", response.data.fecha ? response.data.fecha : '');
                                $(this).find(".listado-gastotipo").attr(
                                    "data-gastotipoid", response.data.gastotipo_id ? response.data.gastotipo_id : '');
                                $(this).find(".listado-gastotipo").text(response.data.gastotipo ? response.data.gastotipo : '');
                                $(this).find(".listado-monto").text(response.data.monto ? response.data.monto : '');
                                $(this).find(".listado-monto").attr("data-monto", response.data.monto ? response.data.monto : '');
                                $(this).find(".listado-comentario").text(response.data.comentario ? response.data.comentario : '');
                                return false;
                            }
                        });
                    }

                    if (response.errors) {
                        response.errors.forEach(element => {
                            msjAlert(element)

                        })
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
            var cn = $(".resumen-total").attr("data-monto")
            var totl = parseFloat(cn) + parseFloat(monto - monto_anterior)
            $(".resumen-total").html(totl)
            $(".resumen-total").attr("data-monto", totl)
        }

    }); // 




    $(document).on("click", ".listado-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var monto = $(this).parent().parent().find(".listado-monto").attr("data-monto");
        var saldo = parseFloat($(".egresos").attr("data-monto"));
        var url = window.location.origin + "/egresos/" + id + "/delete";
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
                var saldoactual = saldo - monto;
                $(".egresos").text(saldoactual);
                $(".egresos").attr("data-monto", saldoactual);

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
            $(thi).html(' <i class="bi bi-trash"></i> ')
        } finally {
            $(thi).html(' <i class="bi bi-trash"></i> ')
        }


    });


    // habilitar boton guardar
    $(document).on("keyup", ".tipogasto", function() {
        $(".tipogasto-nuevo").removeAttr("disabled");
        $(".tipogasto-nuevo").removeClass("disabled");
    });


    // modal nuevo tipo gasto
    $(document).on("click", ".tipogasto-nuevo", async function() {
        var thi = $(this)
        var tipogasto = $.trim($(".tipogasto").val()) ? $(".tipogasto").val() : undefined;
        var url = window.location.origin + '/egresostipos';
        var data = {
            tipogasto: tipogasto
        }

        if (tipogasto == undefined) {
            msjAlert("Ingresa un nombre", true)
            return false;
        }
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)

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

                    if (response.status == "success" && response.message) {
                        msjAlert(response.message)
                        $("#tipo-nuevo").modal("hide");
                    }
                    if (response.status == "error" && response.message) {
                        msjAlert(response.message, true)
                        $("#tipo-nuevo").modal("hide");
                    }
                    if (response.data) {
                        var tr =
                            ` <option value="${response.data.id}">${response.data.tipogasto} </option>`
                        $(".modal-nuevo-gastotipo").append(tr);
                        $(".modal-editar-gastotipo").append(tr);
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
        } catch (error) {
            $(thi).html("Guardar")
        } finally {
            $(thi).html("Guardar")

        }




    }); // 




    $(document).on("change", ".filtro", function() {
        getdata();
    });

    $(document).on("click", " .pagination a", function(e) {
        e.preventDefault();
        var page = $(this).attr("href").split('page=')[1];
        getdata(page);
    });

    async function getdata(page = null) {
        var url = window.location.origin + window.location.pathname + "/filtro";
        var fechadesde = $(".filtro-fechadesde").val();
        var fechahasta = $(".filtro-fechahasta").val();
        var tipogasto = $(".filtro-tipogasto").val();

        var data = {
            fechadesde: fechadesde,
            fechahasta: fechahasta,
            tipogasto: tipogasto,
            page: page
        }

        try {
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
                    // $("#tabla").prepend(span);
                    var span = ` <tr>
                    <td colspan="7">
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
                    var cant = response[1].cantidad ? response[1].cantidad : 0;
                    var tot = response[1].total ? response[1].total : 0;
                    $(".resumen-cantidad").text(cant)
                    $(".resumen-total").text(tot)
                },
                error: function(response) {
                    msjAlert(JSON.parse(response.responseText).message, true)
                }

            });
        } catch (error) {

        } finally {

        }

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