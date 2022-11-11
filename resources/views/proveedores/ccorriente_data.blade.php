<div class="table-responsive mt-4">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Saldo</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody class="listado">
            @if (isset($ccorrientes) && !empty($ccorrientes))
                @foreach ($ccorrientes as $item)
                    <tr>
                        <td hidden class="listado-cc_id" data-cc_id="{{ $item['id'] }}">
                        </td>
                        <td class="text-bold-500">{{ $item['nombre'] }}</td>
                        <td class="listado-monto">{{ $item['monto'] }}</td>
                        <td>
                            <a class="btn btn-info btn-sm  listado-detalles mt-1" href="{{ url('proveedorcc/detalle') }}/{{ $item['id'] }}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Detalles" data-bs-original-title="Detalles" > <i class="bi bi-eye"></i>  </a>
                            <button type="button" class="btn btn-sm btn-success listado-pago mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Realizar pago" data-bs-original-title="Realizar pago"  >Pago</button>
    
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    <div class="mt-2">
        {{ $ccorrientes->render() }}
    </div>
</div>


 