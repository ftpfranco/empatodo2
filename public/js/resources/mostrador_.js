Echo.channel('pedidos-pendientes')
    .listen('EventoPedidos', (e) => {
          
        var agregarPedido2 = async() => {
            if (e && e.mensaje) {
                var estado = e.mensaje.estado
                var articulos = e.mensaje.articulos
                var venta_id = e.mensaje.venta_id
                var cliente = e.mensaje.cliente

                if (estado == "eliminar") {
                    $(".pedido-" + venta_id).remove();
                    return false;
                }

                if (estado == "agregar") {
                    var _articulos = await articulos.map(function(item) {
                        return ` <tr> <td> <strong>${item.cantidad}</strong></td>  <td> <strong>${item.articulo}</strong> </td>  </tr> `;
                    });
                    _articulos = await _articulos.join('');
                    var pedido = `
                    <div class="col-lg-3 col-xl-2 pedido-${venta_id}">
                        <div class="card " style="background-color:#040404 !important ; font-size: 1.2rem !important;">
                            <div class="card-content  " >
                                <div class="card-body  px-0 pb-0"  >
                                    <div class="px-3">
                                        <div class="form-group">
                                            <h1><strong  style="color: white !important">  ${cliente} </strong></h1>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-hover ">
                                            <tbody class="pedido-listado" style="color: white !important">  ${_articulos} </tbody>
                                        </table>
                                    </div>
    
                                </div>
    
                            </div>
                        </div>
                    </div>
                `;
                    if ($(".pedidos-pendientes")[0]) $(".pedidos-pendientes").append(pedido);

                }
            }
        }

        // agregarPedido2()

        var agregarPedido = async() => {
            if (e.estado == "eliminar") {
                $(".pedido-" + e.venta_id).remove();
                return false;
            }
            if(e.estado === "refrescar"){
                window.location.href = window.location.href
            }
            var articulos = await e.articulos.map(function(item) {
                return ` <tr> <td> <strong>${item.cantidad}</strong></td>  <td> <strong>${item.articulo}</strong> </td>  </tr> `;
            });
            articulos = await articulos.join('');
            var pedido = `
                        <div class="col-lg-3 col-xl-2 pedido-${e.venta_id}">
                            <div class="card " style="background-color:#040404 !important ; font-size: 1.2rem !important;">
                                <div class="card-content  " >
                                    <div class="card-body  px-0 pb-0"  >
                                        <div class="px-3">
                                            <div class="form-group">
                                                <h1><strong  style="color: white !important">  ${e.cliente} </strong></h1>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-hover ">
                                                <tbody class="pedido-listado" style="color: white !important">  ${articulos} </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    `;
            if ($(".pedidos-pendientes")[0]) $(".pedidos-pendientes").append(pedido);
        };

        agregarPedido();

    });