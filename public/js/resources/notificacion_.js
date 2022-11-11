$(document).ready(function() {

    getNotificaciones();


    async function getNotificaciones() {
        var url = window.location.origin + "/notificaciones"
        if (typeof(Storage) !== undefined && window.sessionStorage.getItem("notificaciones") !== null) {

            cargarNotificaciones(JSON.parse(window.sessionStorage.getItem("notificaciones")));
            return false;
        }

        await $.ajax({
            type: "get",
            url: url,
            data: {},
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == "success" && response.data) {
                    if (typeof(Storage) !== undefined && response.data.data.length > 0) {
                        window.sessionStorage.setItem("notificaciones", JSON.stringify(response
                            .data.data));
                    }
                    cargarNotificaciones(response.data.data);
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
                // msjAlert(JSON.parse(response.responseText).message, true)
            }
        }); // ajax
    }
    // end get ntoficaciones


    // eliminar
    $(document).on('click', '.notificacion-eliminar', async function() {
        var id = $(this).attr("data-id");
        var url = window.location.origin + "/notificaciones";
        var data = {
            id: id,
        }

        if (data.id == undefined) return false;
        // eliminar desde storage
        if (typeof(Storate) !== undefined && window.sessionStorage.getItem("notificaciones") !==
            null) {
            var arr = JSON.parse(window.sessionStorage.getItem("notificaciones"));
            var res = arr.filter((item, index) => {
                if (item.id != id) return item;
            });
            window.sessionStorage.removeItem("notificaciones");
            if (res.length > 0) {
                window.sessionStorage.setItem("notificaciones", JSON.stringify(res));
            }
            cargarNotificaciones(res)
        }
        // eliminar desde storage
        //
        await $.ajax({
            type: "delete",
            url: url,
            data: data,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == "success") {}

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
                // msjAlert(JSON.parse(response.responseText).message, true)
            }
        }); // eliminar

    }); // eliminar



    async function cargarNotificaciones(data) {
        $(".notificaciones").empty();
        if (data.length <= 0) {
            $("#notificaciones").removeClass("bi-bell-fill");
            $("#notificaciones").addClass("bi-bell");
        } else {
            $("#notificaciones").removeClass("bi-bell");
            $("#notificaciones").addClass("bi-bell-fill");
        }
        await $.each(data, function(i, j) {
            var li =
                ` <li><a class="dropdown-item" href="${window.location.origin}/articulos/${j.articulo_id}/editar">${j.descripcion} </a></li>`;
            if ($(".notificaciones")[0]) $(".notificaciones").append(li);
        });
    } // end cargarnotificaciones


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