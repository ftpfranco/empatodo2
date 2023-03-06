<div class="table-responsive ">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Fecha apertura</th>
                <th>Fecha cierre</th>
                <th>Monto inicio</th>
                {{-- <th>Monto estimado</th> --}}
                {{-- <th>Ingresos</th>
                <th>Egresos</th> --}}
                <th>Monto real</th>
                <th>Diferencia</th>
                <th> Tipo </th>
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
                        {{-- <td>{{ $item->monto_estimado }}</td> --}}
                        {{-- <td>{{ $item->ingresos }} </td>
                        <td>{{ $item->egresos }} </td> --}}
                        <td> {{ $item->monto_real }} </td>
                        <td>
                            @if ($item->diferencia>=0)
                            <span class="badge bg-success"> {{ $item->diferencia }}  </span>
                            @endif
                            @if ($item->diferencia<0)
                            <span class="badge bg-danger"> {{ $item->diferencia }}  </span>
                            @endif
                             
                        </td>
                        <td>{{ $item->estado }} </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    {{-- <div class="mt-2">
        @if (isset($historial) && !empty($historial))
            {{ $historial->render() }}
        @endif
    </div> --}}
</div>

 
@if (isset($historial) &&  count($historial) == 0)
<div class="col-12 no-data-historial" id="no-data-historial">
    <div class="card">
        <div class="card-content d-flex justify-content-center ">
            <div class="col-6 col-lg-4 col-md-3 col-2 mb-4 mt-4 mx-4" data-tags="note card notecard">

                <div class="p-3 py-4 mb-2 bg-light text-center rounded">
                    <svg class="" width="5em" height="5em" fill="currentColor">
                        <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#card-checklist"></use>
                    </svg>
                </div>
                <div class="name text-muted text-decoration-none text-center pt-1">
                    Aqu&iacute; podr&aacute;s ver todos las Operaciones y movimientos de caja.
                </div>
            </div>
        </div>
    </div>
</div>
@endif



