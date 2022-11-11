<div class="table-responsive ">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Fecha apertura</th>
                <th>Fecha cierre</th>
                <th>Monto inicio</th>
                <th>Monto estimado</th>
                <th>Ingresos</th>
                <th>Egresos</th>
                <th>Monto real</th>
                <th>Diferencia</th>
                {{-- <th>Estado</th> --}}
            </tr>
        </thead>
        <tbody class="historial">
            @if (isset($historial) && !empty($historial))
                @foreach ($historial as $item)
                    <tr>
                        <td hidden>{{ $item->id }}</td>
                        <td>{{ $item->inicio_fecha }} {{ $item->inicio_hora }}</td>
                        <td> {{ $item->cierre_fecha }} {{ $item->cierre_hora }}</td>
                        <td>{{ $item->monto_inicio }}</td>
                        <td>{{ $item->monto_estimado }}</td>
                        <td>{{ $item->ingresos }} </td>
                        <td>{{ $item->egresos }} </td>
                        <td> {{ $item->monto_real }} </td>
                        <td>
                            @if ($item->diferencia>=0)
                            <span class="badge bg-success"> {{ $item->diferencia }}  </span>
                            @endif
                            @if ($item->diferencia<0)
                            <span class="badge bg-danger"> {{ $item->diferencia }}  </span>
                            @endif
                             
                        </td>
                        {{-- <td>{{ $item->estado }} </td> --}}
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    <div class="mt-2">
        @if (isset($historial) && !empty($historial))
            {{ $historial->render() }}
        @endif
    </div>
</div>
