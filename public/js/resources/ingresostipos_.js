$(document).ready(function() {

    $(document).on("click", ".ingresotipo-nuevo", async function() {
        var thi = $(this)
        var ingresotipo = $.trim($(".ingresotipo").val()) ? $.trim($(".ingresotipo").val()) : undefined
        var url = window.location.origin + "/ingresostipos";
        var data = {
            ingresotipo: ingresotipo
        }

        if (ingresotipo == undefined) {
            msjAlert("Ingresa un nombre ", true)
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
                    if (response.data) {
                        var tr = `
                            <tr>
                                <td hidden class="id" data-id="${response.data.id?response.data.id:''}">
                                </td>
                                <td>
                                    <input class="form-control ingresotipo-list" type="text"  data-status="off" value="${response.data.ingresotipo?response.data.ingresotipo:''}">
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-success btn-sm ingresotipo-editar mt-1" data-bs-toggle="tooltip" data-bs-placement="top"  title="Guardar"  data-bs-original-title="Guardar">  <i class="bi bi-archive"></i> </button>
                                    <button class="btn btn-danger btn-sm ingresotipo-eliminar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i> </button>
                                </td>
                            </tr>
                        `;
                        $("#tipo-nuevo").modal("hide")
                        $(".listado").append(tr);
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
            $(".ingresotipo").val('')
        }


    }); // 


    $(document).on("keyup", ".ingresotipo-list", function() {
        $(this).attr("data-status", "on");
    });


    $(document).on("click", ".ingresotipo-editar", async function() {
        var thi = $(this)
        var ingresotipo = $(this).parent().parent().find(".ingresotipo-list").val();
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var status = $(this).parent().parent().find(".ingresotipo-list").attr("data-status");
        var url = window.location.origin + "/ingresostipos/" + id + "/editar";

        var data = {
            ingresotipo: ingresotipo
        }

        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)

        // desabilitar
        $(".ingresotipo-list").attr("data-status", "off");
        try {
            if (status == "on") {
                await $.ajax({
                    type: "put",
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
                        msjAlert(JSON.parse(response.responseText).message, true)
                    }
                }); // ajax
            }

        } catch (error) {
            $(thi).html('<i class="bi bi-archive"></i>')
        } finally {
            $(thi).html('<i class="bi bi-archive"></i>')

        }
    });




    // eliminar
    $(document).on("click", ".ingresotipo-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var url = window.location.origin + "/ingresostipos/" + id + "/eliminar";
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
                        if (response.errors) {
                            response.errors.forEach(element => {
                                msjAlert(element, true)
                            })
                        }
                        if (response.status == "success") {
                            $(thi).parent().parent().remove();
                        }
                        if (response.status == "success" && response.message) {
                            $(thi).parent().parent().remove();
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



    });







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