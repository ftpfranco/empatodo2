<div class="table-responsive mt-4">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th class="text-end">Total a pagar</th>
                <th class="text-end">Descuento</th>
                <th class="text-end">Total recibido</th>
                <th>Estado pedido</th>
                <th>Tipo pago</th>
                <th>Estado pago</th>
                <th class="text-end">Accion</th>
            </tr>
        </thead>
        <tbody class="listado-articulos listado">
            @if (isset($ventas) && count($ventas)>0)
                @php
                    $total_venta  = count($ventas)
                @endphp
                @foreach ($ventas as $key=>$item)
                    <tr>
                        <td hidden class="id" data-id="{{ $item->id }}"></td>
                        <td  data-label="#" class="bg-active">{{$total_venta - $key}}</td>
                        <td data-label="Fecha"> <small>{{ $item->hora }}</small></td>
                        <td data-label="Cliente" > {{ $item->cliente }}</td>
                        <td data-label="Monto"   class="text-end">{{ $item->monto }}</td>
                        <td data-label="Descuento" class="text-end">{{ $item->descuento_importe }}</td>
                        <td data-label="Recibido"  class="text-end">
                            @if ( $item->total_recibido > $item->monto)
                                <span class="badge bg-success">{{ $item->total_recibido }}</span>
                            @elseif(   $item->total_recibido < $item->monto )
                                <span class="badge bg-danger">{{ $item->total_recibido }}</span>
                            @else 
                                {{ $item->total_recibido }}
                            @endif
                            
                        </td>
                        <td data-label="Envio" class="estado-envio"> {{ $item->estadoenvio }}</td>
                        <td data-label="Pago"> {{ $item->tipo_pago }}</td>
                        <td data-label="Estado Pago">
                            @if ($item->pago_completo)
                                <span class="badge bg-success">Completo</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </td>

                        <td class="text-end">
                            @if (isset($item->tipoenvio_id) && $item->tipoenvio_id ==2)
                            <label class="btn btn-info btn-sm mt-1 listado-enviado"  data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar como entregado" data-bs-original-title="Marcar como entregado" > <i class="bi bi-check-all"></i> </label>
                            @endif
                            
                            <a  class="btn btn-success btn-sm mt-1  " href="{{url("ventas/edit",$item->id)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar"> <i class="bi bi-pencil"></i> </a>
                            @can("venta-destroy")
                            <button class="btn btn-danger btn-sm mt-1 listado-eliminar " data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i> </button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @endif



        </tbody>
    </table>

    <div class=" mt-2">
        {{-- @if (isset($ventas) && count($ventas)>0 && $render)
            {{ $ventas->render() }}
        @endif --}}
    </div>
</div>
