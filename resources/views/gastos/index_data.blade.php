@if (isset($gastos) && count($gastos)>0)

<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>{{isset($con_fecha) ? "Fecha":"Hora"}}  </th>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Comentario</th>
                <th class="text-end">Accion</th>
            </tr>
        </thead>
        <tbody class="listado">
            @if (isset($gastos) && count($gastos)>0)
                @foreach ($gastos as $item)
                    <tr>
                        <td hidden class="listado-id" data-id="{{ $item['id'] }}">
                        </td>
                        @php
                            $fecha = str_replace("/","-",$item['fecha']) 
                        @endphp
                        <td data-label="{{isset($con_fecha) ? "Fecha":"Hora"}}" class="listado-fecha" data-fecha="{{ $fecha }}">
                           {{isset($con_fecha) ? $item["fecha"] : ''}} <small>{{$item["hora"]}}</small></td>
                        <td data-label="Categoria" class="listado-gastotipo text-bold-500 " data-gastotipoid="{{ $item['gastotipo_id'] }}">
                            {{ $item['gastotipo'] }} </td>
                        <td data-label="Monto" class="listado-monto" data-monto="{{ $item['monto'] }}">
                            {{ $item['monto'] }}</td>
                        <td data-label="Comentario " class="listado-comentario text-bold-500">
                            {{ trim($item['comentario']) }} </td>
                        <td class="text-end">
                            <button type="button" class="btn btn-success btn-sm listado-editar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar" > <i class="bi bi-pencil"></i> </button>
                            @can("egresos-destroy")
                            @if ( $fecha == date("Y-m-d"))
                            <button type="button" class="btn btn-danger btn-sm listado-eliminar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >   <i class="bi bi-trash"></i>    </button>
                            @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    <div class="mt-2  ">
        @if (isset($gastos) && count($gastos)>0)
            {{ $gastos->render() }}
        @endif
    </div>
</div>

@else
<div class="col-12">
    <div class="card">
        <div class="card-content d-flex justify-content-center ">
            <div class="col-6 col-lg-4 col-md-3 col-2 mb-4 mt-4 mx-4" data-tags="note card notecard">

                <div class="p-3 py-4 mb-2 bg-light text-center rounded">
                    <svg class="" width="5em" height="5em" fill="currentColor">
                        <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#graph-down"></use>
                    </svg>
                </div>
                <div class="name text-muted text-decoration-none text-center pt-1">
                    Aqui podr&aacute;s administrar todos tus gastos y/o egresos.
                </div>
            </div>
        </div>
    </div>
</div>

@endif
