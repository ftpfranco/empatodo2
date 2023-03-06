@if (isset($ventas) && count($ventas) > 0)
<div class="table-responsive mt-4">
    <table class="table table-hover mb-0  ">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
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
        <tbody class="listado">
            @if (isset($ventas) && !empty($ventas))
                @php
                    $total_ventas = count($ventas)
                @endphp
                @foreach ($ventas as  $key => $item)
                    <tr>
                        <td type="hidden" hidden class="id" data-id="{{ $item->id }}"></td>
                        <td data-label="#" class="bg-active">{{$total_ventas - $key}}</td>
                        <td data-label="Fecha">{{ $item->fecha }} <small>{{ $item->hora }}</small></td>
                        <td data-label="Cliente"> {!! (!empty($item->cliente) ) ? $item->cliente:   "<span class='tachado'>Sin nombre </span>"  !!}</td>
                        <td data-label="Monto" data-monto="{{ $item->monto?$item->monto:0 }}" class="text-end monto">{{ $item->monto ?$item->monto:0}}</td>
                        <td data-label="Descuento" class="text-end">{{ $item->descuento_importe }}</td>
                        <td data-label="Recibido" class="text-end">
                            @if ($item->total_recibido > $item->monto)
                                <span class="badge bg-success">{{ $item->total_recibido }}</span>
                            @elseif($item->total_recibido < $item->monto)
                                <span class="badge bg-danger">{{ $item->total_recibido }}</span>
                            @else
                                {{ $item->total_recibido }}
                            @endif
                        </td>

                        <td data-label="Envio"> {{ $item->estadoenvio ?$item->estadoenvio : ''}}</td>
                        <td data-label="Pago" class="modopago" data-modopago="{{ $item->tipo_pago?$item->tipo_pago: '' }}"> {{ $item->tipo_pago?$item->tipo_pago: '' }}</td>
                        <td data-label="Estado Pago">
                            @if ($item->pago_completo)
                                <span class="badge bg-success">Completo</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </td>

                        <td class="text-end">
                                    <button class="btn btn-info  btn-sm mt-1 listado-detalles " data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Detalles" data-bs-original-title="Detalles"> <i
                                            class="bi bi-eye"></i> </button>
                                    

                                    {{-- <a  class="btn btn-success  btn-sm mt-1  " href="{{url("ventas/edit",$item->id)}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar"> <i class="bi bi-pencil"></i> </a> --}}
                                    <button class="btn btn-danger  btn-sm mt-1 listado-eliminar  " data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i
                                            class="bi bi-trash"></i> </button>

                        </td>
                    </tr>
                @endforeach
            @endif



        </tbody>
    </table>


    <div class=" mt-3 pt-3 mb-2 pb-2">
        @if (isset($ventas) && !empty($ventas) && $render)
            {{ $ventas->render() }}
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
                        <use xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#book"></use>

                    </svg>
                </div>
                <div class="name text-muted text-decoration-none text-center pt-1">
                    Aqui podras listar todas tus ventas realizadas.
                </div>
            </div>
        </div>
    </div>
</div>

@endif