$(document).ready(function() {

    $(document).on("keyup", ".tipogasto", function() {
        $(".tipogasto-nuevo").removeAttr("disabled");
        $(".tipogasto-nuevo").removeClass("disabled");
    });


    $(document).on("click", ".tipogasto-nuevo", async function() {
        var thi = $(this)
        var tipogasto = $.trim($(".tipogasto").val()) ? $.trim($(".tipogasto").val()) : undefined;
        var url = window.location.origin + "/egresostipos";
        var data = {
            tipogasto: tipogasto
        }

        if (tipogasto == undefined) {
            msjAlert("Ingrese un nombre", true)
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
                    }
                    if (response.status == "error" && response.message) {
                        msjAlert(response.message, true)
                    }
                    if (response.data) {
                        var tr = `
                            <tr>
                                <td hidden class="id" data-id="${response.data.id}"> </td>
                                <td>
                                    <input class="form-control tipogasto-list" type="text" data-status="off" value="${response.data.tipogasto}">
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-success btn-sm tipogasto-editar mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Guardar"  data-bs-original-title="Guardar"> <i class="bi bi-archive"></i>  </button>
                                    <button class="btn btn-danger btn-sm tipogasto-eliminar mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i> </button>
                                </td>
                            </tr>
                        `;
                        $(".listado").append(tr);
                        $("#tipo-nuevo").modal("hide");
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
            $(".tipogasto").val('')
        }


    }); // 


    $(document).on("keyup", ".tipogasto-list", function() {
        $(this).attr("data-status", "on");
    });


    $(document).on("click", ".tipogasto-editar", async function() {
        var thi = $(this)
        var tipogasto = $(this).parent().parent().find(".tipogasto-list").val();
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var status = $(this).parent().parent().find(".tipogasto-list").attr("data-status");
        var url = window.location.origin + "/egresostipos/" + id + "/editar";

        var data = {
            tipogasto: tipogasto
        }

        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)

        // desabilitar
        $(".tipogasto-list").attr("data-status", "off");
        try {
            if (status == "on") {
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
            $(thi).html('<i class="bi bi-archive"></i> ')
        } finally {
            $(thi).html('<i class="bi bi-archive"></i> ')

        }


    });









    $(document).on("click", ".tipogasto-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".id").attr("data-id");
        var url = window.location.origin + window.location.pathname + "/" + id + "/eliminar";
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
                    type: "post",
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