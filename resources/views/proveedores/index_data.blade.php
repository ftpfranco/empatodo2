<!-- tabla -->
<div class="table-responsive mt-4">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Mail</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Dni</th>
                <th>Localidad</th>
                {{-- <th> Estado </th> --}}
                <th class="text-end">Accion</th>
            </tr>
        </thead>
        <tbody class="listado">
            @if (isset($proveedores) && !empty($proveedores))
                @foreach ($proveedores as $item)
                    <tr>
                        <td class="listado-id" data-id="{{ $item['id'] }}" hidden>
                            {{ $item['id'] }}</td>
                        <td class="listado-nombre"> {{ $item['nombre'] }}</td>
                        <td class="listado-email"> {{ $item['email'] }} </td>
                        <td class="listado-telefono"> {{ $item['telefono'] }} </td>
                        <td class="listado-direccion"> {{ $item['direccion'] }} </td>
                        <td class="listado-dni" data-tipoidentificacionid="{{ $item['tipo_identificacion_id'] }}">
                            {{ $item['nro_dni'] }}</td>
                        <td class="listado-localidad"> {{ $item['localidad'] }} </td>
                         
                        <td class="text-end">
                            <button class="btn btn-success btn-sm listado-editar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar" >  <i class="bi bi-pencil"></i>  </button>
                            <button class="btn btn-danger btn-sm listado-eliminar mt-1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i>  </button>
 
                        </td>
                    </tr>
                @endforeach
            @endif
            {{-- <tr>
                <td colspan="7">
                    <div id="loader active">
                        <div class="spinner">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
                    </div>
                </td>
            </tr> --}}
            
        </tbody>
       
    </table> 
    <div class="mt-2">
        @if (isset($proveedores) && !empty($proveedores))
            {{ $proveedores->render() }}
        @endif
    </div>
</div>
