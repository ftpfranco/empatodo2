$(document).ready(function() {

    $(document).on("keyup", "input,textarea", function() {
        habilitar()
    });

    $(document).on("change", "select", function() {
        habilitar()
    });

    function habilitar() {
        $(".modal-ingreso-guardar").removeAttr("disabled");
        $(".modal-ingreso-guardar").removeClass("disabled");

        $(".tipoingreso-nuevo").removeAttr("disabled");
        $(".tipoingreso-nuevo").removeClass("disabled");

        $(".modal-ingreso-editar-guardar").removeAttr("disabled");
        $(".modal-ingreso-editar-guardar").removeClass("disabled");
    }

    // modal  ingreso nuevo guardar
    $(document).on("click", ".modal-ingreso-guardar", async function() {
        var thi = $(this)
        var fecha = $(".modal-ingreso-fecha").val();
        var tipoingreso = $(".modal-ingreso-tipoingreso").val() !== "-1" ? $(".modal-ingreso-tipoingreso").val() : undefined
        var monto = $.trim($(".modal-ingreso-monto").val()) ? $(".modal-ingreso-monto").val() : undefined;
        var comentario = $.trim($(".modal-ingreso-comentario").val());
        var url = window.location.origin + "/ingresos";

        var data = {
            fecha: fecha,
            tipoingreso: tipoingreso,
            monto: monto,
            comentario: comentario
        }

        if (tipoingreso == undefined) { msjAlert("Selecciona una Categoria", true); return false }
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
                    if (response.status == "success" && response.data) {
                        $("#ingreso-nuevo").modal("hide");
                        $(".modal-ingreso-fecha").val('');
                        $(".modal-ingreso-tipoingreso").val('-1');
                        $(".modal-ingreso-monto").val('')
                        $(".modal-ingreso-comentario").val('')
                    }
                    if (response.status == "success" && response.message) {
                        msjAlert(response.message)
                    }
                    if (response.status == "error" && response.message) {
                        msjAlert(response.message, true)
                    }
                    if (response.data) {
                        if ($(".listado")[0] == undefined) {
                            var trr = `
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>  Hora </th>
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
                                <td hidden class="listado-id" data-id="${response.data.id?response.data.id:''}"> </td>
                                <td data-label="${response.data.fecha?'Fecha':'Hora'}" class="listado-fecha" data-fecha="${response.data.fecha?response.data.fecha:''}">  <small> ${response.data.hora?response.data.hora:''} </small> </td>
                                <td data-label="Categoria" class="listado-ingresotipo text-bold-500 " data-ingresotipoid="${response.data.ingresotipo_id?response.data.ingresotipo_id:''}">${response.data.ingresotipo?response.data.ingresotipo:''}</td>
                                <td data-label="Monto" class="listado-monto" data-monto="${response.data.monto?response.data.monto:''}"> ${response.data.monto?response.data.monto:''} </td>
                                <td data-label="Comentario" class="listado-comentario text-bold-500">  ${response.data.comentario?response.data.comentario:''} </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-success btn-sm listado-editar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar" > <i class="bi bi-pencil"></i> </button>
                                    <button type="button" class="btn btn-danger btn-sm listado-eliminar mt-1"data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >  <i class="bi bi-trash"></i>  </button>
    
                                </td>
                            </tr>
                            `;
                        if ($(".listado")[0]) $(".listado").prepend(tr);


                        var monto = $(".ingresos").attr("data-monto");
                        var total = parseFloat(monto) + parseFloat(response.data.monto);
                        total = parseFloat(total).toFixed(2);
                        $(".ingresos").attr("data-monto", total);
                        $(".ingresos").text(total);

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


    // modal  ingreso nuevo guardar
    $(document).on("click", ".modal-ingreso-editar-guardar", async function() {
        var thi = $(this)
        var id = $(".modal-ingreso-editar-id").val();
        var fecha = $(".modal-ingreso-editar-fecha").val();
        var tipoingreso = $(".modal-ingreso-editar-ingresotipo").val() !== "-1" ? $(".modal-ingreso-editar-ingresotipo").val() : undefined
        var monto = $.trim($(".modal-ingreso-editar-monto").val()) ? $(".modal-ingreso-editar-monto").val() : undefined;
        var comentario = $.trim($(".modal-ingreso-editar-comentario").val());
        var url = window.location.origin + "/ingresos";


        var data = {
            id: id,
            fecha: fecha,
            tipoingreso: tipoingreso,
            monto: monto,
            comentario: comentario
        }

        if (tipoingreso == undefined) { msjAlert("Selecciona una Categoria", true); return false }
        if (monto == undefined) { msjAlert("Ingresa un monto", true); return false }


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
                        $("#ingreso-editar").modal("hide");
                    }

                    if (response.data) {

                        $(".listado>tr").each(function() {
                            var id = $(this).find(".listado-id").attr("data-id");
                            if (id === response.data.id) {
                                $(this).find(".listado-fecha").attr("data-fecha",
                                    response.data.fecha ? response.data.fecha : '');
                                $(this).find(".listado-fecha").text(response.data.fecha ? response.data.fecha : '');
                                $(this).find(".listado-ingresotipo").attr(
                                    "data-ingresotipoid", response.data.ingresotipo_id ? response.data.ingresotipo_id : '');
                                $(this).find(".listado-ingresotipo").text(response.data.ingresotipo ? response.data.ingresotipo : '');
                                $(this).find(".listado-monto").text(response.data.monto ? response.data.monto : '');
                                $(this).find(".listado-comentario").text(response.data.comentario ? response.data.comentario : '');
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
            $(thi).html("Guardar")
        } finally {
            $(thi).html("Guardar")

        }





    });


    // click listado editar
    $(document).on("click", ".listado-editar", function() {
        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var fecha = $(this).parent().parent().find(".listado-fecha").attr("data-fecha");
        var tipoingreso_id = $(this).parent().parent().find(".listado-ingresotipo").attr(
            "data-ingresotipoid");
        var monto = $(this).parent().parent().find(".listado-monto").attr("data-monto");
        var comentario = $.trim($(this).parent().parent().find(".listado-comentario").text());

        $(".modal-ingreso-editar-id").val(id);
        $(".modal-ingreso-editar-fecha").val(fecha);
        $(".modal-ingreso-editar-ingresotipo").val(tipoingreso_id)
        $(".modal-ingreso-editar-monto").val(monto);
        $(".modal-ingreso-editar-monto").attr("data-monto", monto);
        $(".modal-ingreso-editar-comentario").val(comentario);

        $("#ingreso-editar").modal("show");
    });



    $(document).on("click", ".listado-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".listado-id").attr("data-id");
        var monto = $(this).parent().parent().find(".listado-monto").attr("data-monto");
        var saldo = parseFloat($(".ingresos").attr("data-monto"));
        var url = window.location.origin + "/ingresos/" + id + "/delete";
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
                $(".ingresos").text(saldoactual);
                $(".ingresos").attr("data-monto", saldoactual);

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
            $(thi).html('<i class="bi bi-trash"></i> ')
        } finally {
            $(thi).html('<i class="bi bi-trash"></i> ')

        }




    });



    // modal nuevo tipo ingreso
    // $(document).on("click", ".tipoingreso-nuevo", async function() {
    //     var ingresotipo = $(".tipoingreso").val();
    //     var url = window.location.origin + '/ingresostipos';
    //     var data = {
    //         ingresotipo: ingresotipo
    //     }
    //     console.log("asdasdf", ingresotipo)
    //     await $.ajax({
    //         type: "post",
    //         url: url,
    //         data: data,
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             if (response.status == "success") {
    //                 $("#tipo-nuevo").modal("hide");
    //             }
    //             if (response.status == "success" && response.message) {
    //                 msjAlert(response.message)
    //             }
    //             if (response.status == "error" && response.message) {
    //                 msjAlert(response.message, true)
    //             }
    //             if (response.data) {
    //                 var tr =
    //                     ` <option value="${response.data.id}">${response.data.ingresotipo} </option>`
    //                 $(".modal-ingreso-tipoingreso").append(tr);
    //                 $(".modal-ingreso-editar-ingresotipo").append(tr);
    //             }

    //             if (response.errors) {
    //                 response.errors.forEach(element => {
    //                     msjAlert(element, true)
    //                 })
    //             }

    //         },
    //         error: function(response) {
    //             msjAlert(JSON.parse(response.responseText).message, true)
    //         }
    //     }); // ajax


    // }); // 





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
        var fechadesde = $.trim($(".filtro-fechadesde").val())
        var fechahasta = $.trim($(".filtro-fechahasta").val())
        var tipoingreso = $.trim($(".filtro-tipoingreso").val())

        var data = {
            fechadesde: fechadesde,
            fechahasta: fechahasta,
            tipoingreso: tipoingreso,
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
                if ($("#tabla")[0]) $("#tabla").html(response);
                var cant = response[1].cantidad ? response[1].cantidad : 0;
                var tot = response[1].total ? response[1].total : 0;
                $(".resumen-cantidad").text(cant)
                $(".resumen-total").text(tot)
                $(".resumen-total").attr("data-monto", tot)
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