@if (isset($empleados) && count($empleados) > 0)
<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Mail</th>
                <th>Horarios</th>
                <th>Telefono</th>
                <th>Dni</th>
                <th>Direccion</th>
                <th>Localidad</th>
                <th>Habilitado</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody class="listado" id="listado">
            @if (isset($empleados) && !empty($empleados))
                @foreach ($empleados as $item)
                    <tr>
                        <td class="listado-id" data-id="{{ $item['id'] }}" hidden>
                            {{ $item['id'] }}</td>
                        <td class="listado-nombre"> {{ $item['nombre'] }}</td>
                        <td class="listado-email"> {{ $item['email'] }} </td>
                        <td class="listado-horarios"> {{ $item['horarios'] }} </td>
                        
                        {{-- <td class="listado-horarios-t1-start" hidden>{{ date("H:i",strtotime($item['time1_start'])) }}</td>
                        <td class="listado-horarios-t1-end" hidden>{{ date("H:i",strtotime($item['time1_end']))  }}</td>
                        <td class="listado-horarios-t2-start" hidden>{{ date("H:i",strtotime($item['time2_start'])) }}</td>
                        <td class="listado-horarios-t2-end" hidden>{{ date("H:i",strtotime($item['time2_end'])) }}</td> --}}

                        <td class="listado-telefono"> {{ $item['telefono'] }} </td>
                        <td class="listado-dni" data-tipoidentificacionid="{{ $item['tipo_identificacion_id'] }}">
                            {{ $item['nro_dni'] }}</td>
                        <td class="listado-direccion"> {{ $item['direccion'] }} </td>
                        <td class="listado-localidad"> {{ $item['localidad'] }} </td>
                        <td class="listado-habilitado" data-habilitado="{{ $item['habilitado'] }}">
                            @if ($item['habilitado'])
                                <span class="badge bg-success"> habilitado </span>
                            @else
                                <span class="badge bg-warning"> no habilitado </span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm listado-editar mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar" >   <i class="bi bi-pencil"></i>  </button>
                            <button class="btn btn-danger btn-sm listado-eliminar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar" >  <i class="bi bi-trash"></i>  </button>
  
                        </td>
                    </tr>


                @endforeach
            @endif


        </tbody>
    </table>
    <div class="mt-2">
        @if (isset($empleados) && !empty($empleados))
            {{ $empleados->render() }}
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
                        <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#file-person-fill"></use>
                    </svg>
                </div>
                <div class="name text-muted text-decoration-none text-center pt-1">
                    Aqui puedes administrar tus empleados
                </div>
            </div>
        </div>
    </div>
</div>
@endif
