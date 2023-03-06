$(document).ready(function () {
    // click boton modal guardar
    $(document).on('click', '.abrir-caja', async function () {
        var thi = $(this)
        var fecha = $.trim($('#fecha').val())
        var hora = $('#hora').val()
        var monto = $.trim($('#monto').val())  ? parseFloat($('#monto').val()).toFixed(2) : 0
        var url = window.location.origin + '/cajas/abrir'

        var data = {
            fecha: fecha,
            hora: hora,
            monto: monto,
        }
        if (typeof monto == 'undefined') {
            msjAlert("Debe especificar un monto", true)
            return true
        }

        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)

        try {
            await $.ajax({
                type: 'post',
                url: url,
                data: data,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.status == "success" && response.data) {
                        $("#no-caja-abierta").html('');
                        var tr = `
                            <tr>
                                <td hidden  class="caja_id"> ${response.data.id} </td>
                                <td class="caja_fecha"> ${response.data.inicio_fecha} ${response.data.inicio_hora}</td>
                                <td class="caja_montoinicio" data-monto="${response.data.monto_inicio} ">  ${response.data.monto_inicio}  </td>
                                <td class="caja_montoacumulado" data-monto="${response.data.monto_inicio} ">  ${response.data.monto_inicio}  </td>
                                <td>
                                    <button class="btn btn-success btn-sm cerrar-caja" > Cerrar</button>
                                </td>
                            </tr>
                        `
                        $('.caja-abierta').html(tr)
                        $('#apertura-caja').modal('hide')
                        $(".boton-abrir-caja").empty()
                    }
                    if (response.errors) {
                        response.errors.forEach((element) => {
                            msjAlert(element, true)
                        })
                    }
                    if (response.message) {
                        msjAlert(response.message, false)
                    }
                },
                error: function (response) { },
            })
        } catch (error) { } finally {
            $('#monto').val('')
            $(thi).html("Guardar")
        }
    }) //

    function addZero(i) {
        if (i < 10) { i = "0" + i }
        return i;
    }

    // boton cerrar caja
    $(document).on('click', '.cerrar-caja', function () {
        var montoinicio = $(this)
            .parent()
            .parent()
            .find('.caja_montoinicio')
            .attr('data-monto')
        var montototal = $(this)
            .parent()
            .parent()
            .find('.caja_montoacumulado')
            .attr('data-monto')
        var date = new Date()
        var fecha = date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate()
        var hora = date.getHours() + ":" + addZero(date.getMinutes())
        $(".cerrar-fecha").val(fecha)
        $(".cerrar-hora").val(hora)
        $('.cerrar-monto-inicio').val(montoinicio)
        $('.cerrar-monto-total').val(montototal)
        $('#cerrar-caja').modal('show')
    })

    // modal boton  cerrar caja
    $(document).on('click', '.modal-cerrar-caja', async function () {
        var thi = $(this)
        var monto_real = $.trim($('.cerrar-monto-real').val()) ? parseFloat($('.cerrar-monto-real').val()).toFixed(2) : undefined
        var fecha = $('.cerrar-fecha').val()
        var hora = $('.cerrar-hora').val()
        var comentario = $.trim($(".comentario").val())
        var turno_cierre = $(".cierre-caja-turno").val()

        var url = window.location.origin + '/cajas/cerrar'

        if (turno_cierre == '-1') {
            msjAlert("Selecciona un Turno de Cierre de caja ", true)
            return false
        }

        var data = {
            monto_real: monto_real,
            fecha: fecha,
            hora: hora,
            comentario: comentario,
            turno_cierre: turno_cierre
        }

        if (typeof monto_real === 'undefined') {
            msjAlert("Debe especificar un monto real ", true)
            return false
        }
        var span =
            ' <div class="spinner-border" role="status" style="width:1rem !important;height:1rem !important"> <span class="visually-hidden">Loading...</span>  </div>';
        $(thi).html(span)

        try {
            await $.ajax({
                type: 'post',
                url: url,
                data: data,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.status == 'success' && turno_cierre== 4 ) {
                        $('.caja-abierta').html('')
                        $(".boton-abrir-caja").html( '<button class="btn btn-outline-success btn-sm mx-1 " data-bs-toggle="modal" data-bs-target="#apertura-caja"> ABRIR </button>' )
                        $("#no-data-historial").html('')
                        var ms = `
                                    <div class="card">
                                        <div class="card-content d-flex justify-content-center ">
                                            <div class="col-6 col-lg-4 col-md-3 col-2 mb-4 mt-4 mx-4" data-tags="note card notecard">
                                                <div class="p-3 py-4 mb-2 bg-light text-center rounded">
                                                    <svg class="" width="5em" height="5em" fill="currentColor">
                                                        <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#folder2-open"></use>
                                                    </svg>
                                                </div>
                                                <div class="name text-muted text-decoration-none text-center pt-1">
                                                    Aqu&iacute; podr&aacute;s listar y administrar todas las cajas disponibles .
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `
                        $("#no-caja-abierta").html(ms);
                    }

                    if (response.data) {
                        $(".caja_montoinicio").html(monto_real) 
                        $(".caja_montoacumulado").html(monto_real) 
                        var diferencia = `<span class="badge bg-success"> ${response.data.diferencia ? response.data.diferencia : ''
                            }  </span>`
                        if (response.data.diferencia < 0) {
                            diferencia = `<span class="badge bg-danger"> ${response.data.diferencia ? response.data.diferencia : '0'  }  </span>`
                        }
                        var tr = `
                            <tr>
                                <td hidden class="caja_id"> ${response.data.id ? response.data.id : ''
                            } </td>
                                <td> ${response.data.inicio_fecha
                                ? response.data.inicio_fecha
                                : ''
                            } ${response.data.inicio_hora ? response.data.inicio_hora : ''
                            }</td>
                                <td> ${response.data.cierre_fecha
                                ? response.data.cierre_fecha
                                : ''
                            } ${response.data.cierre_hora ? response.data.cierre_hora : ''
                            }</td>
                                <td>  ${response.data.monto_inicio
                                ? response.data.monto_inicio
                                : ''
                            }  </td>
                                <td> ${response.data.monto_real ? response.data.monto_real : '' } </td>
                                <td> ${diferencia} </td>
                                <td> ${response.data.estado ? response.data.estado : '' } </td>
                            </tr>
                        `
                        $('.historial').prepend(tr)
                        $('#cerrar-caja').modal('hide')
                        // $(".boton-abrir-caja").html( '<button class="btn btn-outline-success btn-sm mx-1 " data-bs-toggle="modal" data-bs-target="#apertura-caja"> ABRIR </button>' )
                    }
                    if (response.errors) {
                        response.errors.forEach((element) => {
                            msjAlert(element, true)
                        })
                    }
                    if (response.message) {
                        msjAlert(response.message, false)
                    }
                },
                error: function (response) {
                    msjAlert(JSON.parse(response.responseText).message, true)
                },
            }) //
        } catch (error) { } finally {
            $('.cerrar-monto-real').val('')
            $(thi).html("Guardar")
        }
    })

    // $(document).on("click", ".registro-ingreso-guardar", function() {
    //     var url = window.location.origin + window.location.pathname + "/ingreso";
    //     var importe = $(".ingreso-importe").val();
    //     var comentario = $.trim($(".ingreso-comentario").val());

    //     // validaciones
    //     // end validaciones

    //     var data = {
    //         importe: importe,
    //         comentario: comentario
    //     }
    //     console.log(data)

    //     $.ajax({
    //         type: "post",
    //         url: url,
    //         data: data,
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             console.log(response)

    //             if (response.data) {
    //                 var tr = `
    //                     <tr>
    //                         <td hidden class="caja_id"> ${response.data.id} </td>
    //                         <td class="caja_fecha"> ${response.data.inicio_fecha} ${response.data.inicio_hora}</td>
    //                         <td class="caja_montoinicio">  ${response.data.monto_inicio}  </td>
    //                         <td> ${response.data.monto_estimado} </td>
    //                         <td> ${response.data.ingresos} </td>
    //                         <td> ${response.data.egresos} </td>
    //                         <td>
    //                             <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#default"> Cerrar</button>
    //                         </td>
    //                     </tr>
    //                 `;
    //                 $(".caja-abierta").html(tr);
    //                 $("#ingreso-caja").modal("hide")
    //             }
    //             if (response.errors) {
    //                 response.errors.forEach(element => {
    //                     console.log(element)
    //                     Toastify({
    //                         text: element,
    //                         duration: 3000,
    //                         close: true,
    //                         //backgroundColor: "#4fbe87"
    //                     }).showToast();
    //                 })
    //             }
    //             if (response.message) {

    //                 Toastify({
    //                     text: response.message,
    //                     duration: 3000,
    //                     close: true,
    //                     //backgroundColor: "#4fbe87"
    //                 }).showToast();

    //             }
    //         },
    //         error: function(response) {
    //             console.log(response)
    //             Toastify({
    //                 text: JSON.parse(response.responseText).message,
    //                 duration: 3000,
    //                 close: true,
    //                 //backgroundColor: "#4fbe87"
    //             }).showToast();
    //         }

    //     }); //

    // }); //

    // $(document).on("click", ".registro-egreso-guardar", function() {
    //     var importe = $(".egreso-importe").val();
    //     var comentario = $.trim($(".egreso-comentario").val());

    //     // validaciones
    //     // end validaciones

    //     var data = {
    //         importe: importe,
    //         comentario: comentario
    //     }
    //     console.log(data)

    //     $.ajax({
    //         type: "post",
    //         url: "cajas/egreso",
    //         data: data,
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             console.log(response)
    //             if (response.data) {
    //                 var tr = `
    //                     <tr>
    //                         <td hidden class="caja_id"> ${response.data.id} </td>
    //                         <td class="caja_fecha"> ${response.data.inicio_fecha} ${response.data.inicio_hora}</td>
    //                         <td class="caja_montoinicio">  ${response.data.monto_inicio}  </td>
    //                         <td> ${response.data.monto_estimado} </td>
    //                         <td> ${response.data.ingresos} </td>
    //                         <td> ${response.data.egresos} </td>
    //                         <td>
    //                             <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#default"> Cerrar</button>
    //                         </td>
    //                     </tr>
    //                 `;
    //                 $(".caja-abierta").html(tr);
    //                 $("#egreso-caja").modal("hide")
    //             }
    //             if (response.errors) {
    //                 response.errors.forEach(element => {
    //                     console.log(element)
    //                     Toastify({
    //                         text: element,
    //                         duration: 3000,
    //                         close: true,
    //                         //backgroundColor: "#4fbe87"
    //                     }).showToast();
    //                 })
    //             }
    //             if (response.message) {

    //                 Toastify({
    //                     text: response.message,
    //                     duration: 3000,
    //                     close: true,
    //                     //backgroundColor: "#4fbe87"
    //                 }).showToast();

    //             }
    //         },
    //         error: function(response) {
    //             console.log(response)
    //             Toastify({
    //                 text: JSON.parse(response.responseText).message,
    //                 duration: 3000,
    //                 close: true,
    //                 //backgroundColor: "#4fbe87"
    //             }).showToast();
    //         }

    //     }); //

    // }); //

    // $(document).on("change", ".filtro", function() {
    //     getdata();
    // });

    // // paginacion
    // $(document).on("click", " .pagination a", function(e) {
    //     e.preventDefault();
    //     var page = $(this).attr("href").split('page=')[1];
    //     console.log(page)
    //     getdata(page);
    // });

    // function getdata(page = null) {
    //     var url = window.location.origin + window.location.pathname + "/filtro";
    //     var desde = $(".filtro-desde").val();
    //     var hasta = $(".filtro-hasta").val();
    //     console.log(url)
    //     var data = {
    //         desde: desde,
    //         hasta: hasta,
    //         page: page
    //     }

    //     $.ajax({
    //         type: "get",
    //         url: url,
    //         data: data,
    //         dataType: "json",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             console.log(response)
    //             $("#tabla").html(response);
    //         },
    //         error: function(response) {
    //             // Toastify({
    //             //     text: JSON.parse(response.responseText).message,
    //             //     duration: 3000,
    //             //     close: true,
    //             //     //backgroundColor: "#4fbe87"
    //             // }).showToast();
    //         }

    //     });
    // }

    function msjAlert(msj = '', error) {
        var color = '#3cb11f'
        if (error == true) color = '#d73813'
        Toastify({
            text: msj,
            duration: 5000,
            close: true,
            backgroundColor: color,
        }).showToast()
    }
})