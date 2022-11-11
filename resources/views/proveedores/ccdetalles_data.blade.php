<div class="table-responsive ">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Importe</th>
                <th>Saldo anterior</th>
            </tr>
        </thead>
        <tbody class="listado-pagos">
            @if (isset($pagos) && !empty($pagos))
                @foreach ($pagos as $item)
                    <tr>
                        <td hidden class="id" data-id="{{ $item['id'] }}">
                        </td>
                        <td>{{ $item['fecha'] }}</td>
                        <td>{{ $item['monto'] }}</td>
                        <td>{{ $item['monto_anterior'] }}</td>
                        
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    <div class="mt-2">
        @if (isset($pagos) && !empty($pagos))
            {{ $pagos->render() }}
        @endif
    </div>
</div>