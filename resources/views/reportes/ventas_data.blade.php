<div class="table-responsive mt-4">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado pedido</th>
                <th>Estado pago</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($ventas) && !empty($ventas))
                @foreach ($ventas as $item)
                    <tr>
                        <td hidden class="id" data-id="{{ $item->id }}"></td>
                        <td>{{ $item->fecha }} <small>{{ $item->hora }}</small></td>
                        <td> {{ $item->nombre }}</td>
                        <td>{{ $item->monto }}</td>
                        <td> {{ $item->estadoenvio }}</td>
                        <td>
                            @if ($item->pago_completo)
                                <span class="badge bg-success">Completo</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </td>

                        <td>
                            <button class="btn btn-info btn-sm listado-detalles"  data-bs-toggle="tooltip" data-bs-placement="top" title="Detalles" data-bs-original-title="Detalles" > <i class="bi bi-eye"></i> </button>
                            <a  class="btn btn-success btn-sm  " href="{{url("ventas/edit",$item->id)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar"> <i class="bi bi-pencil"></i> </a>
                            <button class="btn btn-danger btn-sm listado-eliminar " data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i> </button>
                            
                        </td>
                    </tr>
                @endforeach
            @endif



        </tbody>
    </table>


    <div class=" mt-2">
        @if (isset($ventas) && !empty($ventas))
        {{ $ventas->render() }}
        @endif

    </div>
</div>
