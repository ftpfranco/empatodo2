$(document).ready(function() {

    $(document).on("keyup", 'input, textarea', function() {
        // $(this).attr("data-key", true);
        habilitar()
    });

    $(document).on("keyup", ".edit-categoria", function() {
        $(this).attr("data-key", true);
    })


    $(document).on("click", '.categoria-editar', async function() {
        var thi = $(this)
        var categoria = $.trim($(this).parent().parent().find('.edit-categoria').val());
        var id = $(this).parent().parent().find(".edit-categoria").attr('data-id');

        var url = window.location.origin + window.location.pathname
        var data = {
            id: id,
            categoria: categoria
        }
        if ($(this).parent().parent().find(".edit-categoria").attr('data-key') == "false") { return false; }

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
                    console.log(response)
                    if (response.status == "success") {
                        $("#nueva-categoria").modal("hide");
                        $(".edit-categoria").attr('data-key', false);
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
                error: function(error) {
                    msjAlert(JSON.parse(response.responseText).message, true)
                }
            }); // ajax
        } catch (error) {
            $(thi).html('<i class="bi bi-archive"></i> ')
        } finally {
            $(thi).html('<i class="bi bi-archive"></i> ')
        }

    }); // categoria-editar

    $(document).on('click', '.categoria-guardar', async function() {
        var thi = $(this)
        var categoria = $.trim($(".categoria").val()) ? $.trim($(".categoria").val()) : undefined
        var url = window.location.origin + "/categorias"

        var data = {
            categoria: categoria,
        }

        if (categoria == undefined) { return false; }

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
                        var tr = `
                            <tr>
                                <td>  <input type="text" class="form-control edit-categoria"  data-key="false" data-id="${response.data.id}" value="${response.data.categoria}"></td>
                                <td class="text-end">
                                    <button class="btn btn-success btn-sm mt-1 categoria-editar" data-bs-toggle="tooltip" data-bs-placement="top" title="Guardar" data-bs-original-title="Guardar"> <i  class="bi bi-archive"></i>  </button>
                                    <button class="btn btn-danger btn-sm mt-1 categoria-eliminar"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i  class="bi bi-trash"></i> </button>

                                </td>
                            </tr>
                        `;

                        $(".categorias-listado").append(tr);
                        $("#nueva-categoria").modal("hide");

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
            $(".categoria").val('');
            deshabilitar()

        }



    }); // on



    // eliminar
    $(document).on("click", ".categoria-eliminar", async function() {
        var thi = $(this)
        var id = $(this).parent().parent().find(".edit-categoria").attr('data-id');
        var url = window.location.origin + "/categorias/" + id + "/delete"

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
            $(thi).html('<i  class="bi bi-trash"></i>')
        } finally {
            $(thi).html('<i  class="bi bi-trash"></i>')
        }


    }); // elminar




    function habilitar() {
        $(".categoria-guardar").removeAttr("disabled");
        $(".categoria-guardar").removeClass("disabled");
    }

    function deshabilitar() {
        $(".categoria-guardar").attr("disabled", "disabled");
        $(".categoria-guardar").addClass("disabled");
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