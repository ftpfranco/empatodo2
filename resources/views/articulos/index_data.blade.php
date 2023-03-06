<!-- tabla -->
<div class="table-responsive mt-4">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>Articulo</th>
                <th>Descripcion</th>
                <th class="text-end">Precio compra</th>
                <th class="text-end">Precio venta</th>
                <th class="text-end">Stock</th>
                <th class="text-end">Stock minimo</th>
                <th>Categoria</th>
                <th class="text-end">Accion</th>
            </tr>
        </thead>
        <tbody class="productos-listado listado">
            @if (isset($articulos) && !empty($articulos))
                @foreach ($articulos as $item)
                    <tr>
                        <td hidden class="listado-id" data-id="{{ $item['id'] }}">
                            {{ $item['id'] }}</td>
                        <td class="listado-articulo text-start"> {{ $item['articulo'] }} </td>
                        <td class="listado-nombre_corto text-start"> {{ $item['nombre_corto'] }} </td>
                        <td data-label="Precio de Compra" class="listado-preciocompra text-end" data-preciocompra="{{ $item['precio_compra'] }}">
                            {{ $item['precio_compra'] ?$item['precio_compra']:'-' }} </td>
                        <td data-label="Precio de Venta" class="listado-precioventa text-end" data-precioventa="{{ $item['precio_venta'] }}">
                            {{ $item['precio_venta']?$item['precio_venta']:'-' }}</td>
                        <td data-label="Stock" class="listado-stock text-end" data-stock="{{ $item['stock'] }}">
                            
                            @if ( $item['stock'] <= 0)
                                <span class="badge bg-danger"> {{ $item['stock']? $item['stock']:'0' }} </span>
                            @else
                                <span > {{ $item['stock']? $item['stock']:'-' }} </span>
                            @endif
                        </td>
                        <td data-label="Stock minimo" class="listado-stockminimo text-end" data-stockminimo="{{ $item['stock_minimo'] }}">
                            {{ $item['stock_minimo']?$item['stock_minimo']:'-' }}</td>
                        <td data-label="Categoria" class="listado-categoria" data-categoriaid="{{ $item['categoria_id'] }}">
                            {{ $item['categoria']?$item['categoria']:'-' }}</td>
                        {{-- <td class="listado-marca" data-marcaid="{{ $item['marca_id'] }}">
                            {{ $item['marca'] }}</td> --}}
                       
                        <td class="text-end">
                            @can("articulo-editar")
                            <button class="btn btn-success btn-sm listado-editar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-bs-original-title="Editar"  > <i class="bi bi-pencil"></i> </button>
                            @endcan
                            @can("articulo-editar-stock")
                            <button class="btn btn-success btn-sm listado-editar-stock mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Incrementar Stock" data-bs-original-title="Incrementar Stock"  > <i class="bi bi-box"></i> </button>
                            @endcan
                            @can("articulo-destroy")
                            <button class="btn btn-danger btn-sm listado-eliminar mt-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-bs-original-title="Eliminar"> <i class="bi bi-trash"></i>  </button>
                            @endcan
                             
                        </td>
                    </tr>
                @endforeach
            @endif


        </tbody>
    </table>
    <div class="mt-2">
        @if (isset($articulos) && !empty($articulos))
            {{ $articulos->render() }}
        @endif
    </div>
</div>
