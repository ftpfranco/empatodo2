<div class="table-responsive mt-4">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>Estado</th>
                <th class="text-end">Accion</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($compras) && !empty($compras))
                @foreach ($compras as $item)
                    <tr>
                        <td hidden class="id" data-id="{{ $item->id }}"></td>
                        <td>{{ $item->fecha }} </td>
                        <td> {{ $item->nombre }}</td>
                        <td>{{ $item->monto }}</td>
                        <td>
                            @if ($item->pago_completo)
                                <span class="badge bg-success">Completo</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button class="btn btn-info btn-sm listado-detalles mt-1" data-bs-toggle="modal" data-bs-target="#detalles-venta" data-bs-placement="top" title="Detalles" data-bs-original-title="Detalles">   <i class="bi bi-eye"></i> </button>
                            <a class="btn btn-success btn-sm mt-1"  href="{{url("compras/edit",$item->id)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar"   >   <i class="bi bi-pencil"></i>  </a>
                            <button class="btn btn-danger btn-sm destroy mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >  <i class="bi bi-trash"></i>  </button>

                        </td>
                    </tr>
                @endforeach
            @endif



        </tbody>
    </table>

    <div class=" mt-2">
        {{ $compras->render() }}
    </div>
</div>
